<?php

namespace App\Http\Controllers;

use App\Exports\IncomeExpenseExport;
use App\Models\Expense;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FinancialReportController extends Controller
{
    /**
     * Pantalla con el resumen mensual de ingresos (ventas) vs egresos (gastos).
     */
    public function index(Request $request)
    {
        $from = $request->filled('from') ? $request->from : Carbon::now()->startOfYear()->format('Y-m-d');
        $to = $request->filled('to') ? $request->to : Carbon::now()->format('Y-m-d');

        $ventasPorMes = Sale::query()
            ->whereDate('paid_at', '>=', $from)
            ->whereDate('paid_at', '<=', $to)
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as periodo, SUM(total) as total")
            ->groupBy('periodo')
            ->pluck('total', 'periodo');

        $gastosPorMes = Expense::query()
            ->whereDate('expense_date', '>=', $from)
            ->whereDate('expense_date', '<=', $to)
            ->selectRaw("DATE_FORMAT(expense_date, '%Y-%m') as periodo, SUM(amount) as total")
            ->groupBy('periodo')
            ->pluck('total', 'periodo');

        $periodos = $ventasPorMes->keys()
            ->merge($gastosPorMes->keys())
            ->unique()
            ->sort()
            ->values();

        $filas = $periodos->map(function ($periodo) use ($ventasPorMes, $gastosPorMes) {
            $ingresos = (float) ($ventasPorMes[$periodo] ?? 0);
            $egresos = (float) ($gastosPorMes[$periodo] ?? 0);

            return [
                'periodo' => $periodo,
                'etiqueta' => Carbon::createFromFormat('Y-m', $periodo)->translatedFormat('F Y'),
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'utilidad' => $ingresos - $egresos,
            ];
        });

        $totales = [
            'ingresos' => $filas->sum('ingresos'),
            'egresos' => $filas->sum('egresos'),
            'utilidad' => $filas->sum('utilidad'),
        ];

        return view('reports.financial', [
            'filas' => $filas,
            'totales' => $totales,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new IncomeExpenseExport($request->from, $request->to),
            'reporte-ingresos-egresos-' . now()->format('Ymd') . '.xlsx'
        );
    }
}
