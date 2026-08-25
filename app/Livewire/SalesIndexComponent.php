<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use Livewire\WithPagination;
use Carbon\Carbon;

class SalesIndexComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $fromDate;
    public $toDate;

    public $totalSales = 0;
    public $totalTips = 0;

    // Modal compartido para Anular / Nota de credito / Enviar correo
    public $modalSaleId = null;
    public $modalAccion = null; // 'anular', 'nota_credito', 'correo'
    public $modalMotivo = '';
    public $modalEmail = '';

    public function mount()
    {
        $this->fromDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->toDate = Carbon::now()->format('Y-m-d');
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingFromDate() { $this->resetPage(); }
    public function updatingToDate() { $this->resetPage(); }

    public function printTicket($saleId)
    {
        $this->dispatch('print-ticket', saleId: $saleId);
    }

    public function abrirModal($saleId, $accion)
    {
        $sale = \App\Models\Sale::find($saleId);

        $this->modalSaleId = $saleId;
        $this->modalAccion = $accion;
        $this->modalMotivo = '';
        $this->modalEmail = $sale->cliente_email ?? '';

        $this->dispatch('open-modal', 'comprobante-accion');
    }

    public function confirmarModal()
    {
        $sale = \App\Models\Sale::findOrFail($this->modalSaleId);

        try {
            if ($this->modalAccion === 'anular') {
                $this->validate(['modalMotivo' => 'required|string|min:5'], [], ['modalMotivo' => 'motivo']);
                app(\App\Services\NubefactService::class)->anular($sale, $this->modalMotivo);
                $mensaje = 'Se solicitó la anulación ante SUNAT.';
            } elseif ($this->modalAccion === 'nota_credito') {
                $this->validate(['modalMotivo' => 'required|string|min:5'], [], ['modalMotivo' => 'motivo']);
                app(\App\Services\NubefactService::class)->notaCredito($sale, $this->modalMotivo);
                $mensaje = 'Nota de crédito generada y enviada a SUNAT.';
            } elseif ($this->modalAccion === 'correo') {
                $this->validate(['modalEmail' => 'required|email'], [], ['modalEmail' => 'correo']);
                $sale->update(['cliente_email' => $this->modalEmail]);
                \Illuminate\Support\Facades\Mail::to($this->modalEmail)->send(new \App\Mail\ComprobanteMail($sale));
                $mensaje = 'Comprobante enviado por correo.';
            } else {
                return;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->dispatch('swal', [
                'title' => 'No se pudo completar',
                'text' => $e->getMessage(),
                'icon' => 'error',
            ]);
            return;
        }

        $this->dispatch('close-modal', 'comprobante-accion');
        $this->modalSaleId = null;
        $this->modalAccion = null;

        $this->dispatch('swal', [
            'title' => 'Listo',
            'text' => $mensaje,
            'icon' => 'success',
        ]);
    }

    /**
     * Reintento manual desde la lista de ventas, para cuando el job
     * automatico ya agoto sus intentos (estado_sunat = error) o cuando
     * el usuario no quiere esperar al siguiente ciclo del worker.
     */
    public function reintentarEmision($saleId)
    {
        $sale = \App\Models\Sale::findOrFail($saleId);

        if (!$sale->requiereSunat()) {
            $this->dispatch('swal', [
                'title' => 'No aplica',
                'text' => 'Esta venta es una nota de venta interna, no se emite ante SUNAT.',
                'icon' => 'info',
            ]);
            return;
        }

        $sale->update(['estado_sunat' => 'pendiente']);

        \App\Jobs\EmitirComprobanteJob::dispatch($sale);

        $this->dispatch('swal', [
            'title' => 'Reintento enviado',
            'text' => 'Se volverá a intentar la emisión en unos segundos.',
            'icon' => 'success',
        ]);
    }

    public function render()
    {
        $baseQuery = Sale::with(['order.table', 'details.product', 'order.user'])
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->fromDate, fn($q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn($q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->whereHas('order.table', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });

        $this->totalSales = (clone $baseQuery)->sum('total');
        $this->totalTips  = (clone $baseQuery)->sum('tip');

        $sales = (clone $baseQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.sales-index-component', [
            'sales' => $sales
        ]);
    }
}