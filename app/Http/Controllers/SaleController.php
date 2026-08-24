<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }


    public function receipt($id)
{
    $sale = Sale::with('details.product', 'details.productSize', 'order.table', 'order.user')->findOrFail($id);

    $contenidoQr = $sale->requiereSunat() && $sale->enlace_pdf
        ? $sale->enlace_pdf
        : 'Venta: ' . $sale->sale_code;

    $qrCodeBase64 = (new QRCode())->render($contenidoQr);

    $empresa = \App\Models\Setting::first();
    $logoBase64 = null;

    if ($empresa && $empresa->logo_path && file_exists(public_path('storage/' . $empresa->logo_path))) {
        $logoData = file_get_contents(public_path('storage/' . $empresa->logo_path));
        $logoMime = mime_content_type(public_path('storage/' . $empresa->logo_path));
        $logoBase64 = 'data:' . $logoMime . ';base64,' . base64_encode($logoData);
    }

    $pdf = Pdf::loadView('sales.receipt', compact('sale', 'qrCodeBase64', 'logoBase64'))
        ->setPaper([0, 0, 226.77, 800], 'portrait');

    return $pdf->stream("ticket_{$id}.pdf");
}

    public function salesPdf(Request $request)
    {
        $config = \App\Models\Setting::first();

        $sales = Sale::with(['order.table', 'order.user'])
            ->when($request->from, fn($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('created_at', '<=', $request->to))
            ->whereHas('order.table', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'config' => $config,
            'sales' => $sales,
            'from' => $request->from,
            'to' => $request->to
        ];

        $pdf = Pdf::loadView('sales.sales-pdf', $data);
        return $pdf->stream('reporte-ventas.pdf');
    }

    public function salesExcel(Request $request)
    {
        $fileName = 'ventas_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new SalesExport($request->all()),
            $fileName
        );
    }
}
