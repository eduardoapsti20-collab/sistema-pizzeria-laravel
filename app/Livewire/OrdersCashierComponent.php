<?php

namespace App\Livewire;

use App\Models\CashRegister;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\Setting;
use App\Services\DocumentoLookupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersCashierComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $detailsToPay = [];
    public $paymentMethods = [];
    public $selectedMethod = null;
    public $selectedDetails = [];
    public $showPaymentModal = false;
    public $paymentAmount = 0;
    public $payments = [];
    public $boxes = [];
    public $boxId;
    public $order;
    public $printer_name;
    public $direct_printing;

    public $subtotal = 0;
    public $tax = 0;
    public $tip = 0;

    // Tipo de comprobante a emitir: nota_venta (sin SUNAT), boleta, factura
    public $tipoComprobante = 'nota_venta';
    public $clienteTipoDocumento = 'DNI'; // DNI o RUC
    public $clienteNumeroDocumento = '';
    public $clienteDenominacion = '';
    public $clienteDireccion = '';
    public $buscandoDocumento = false;
    public $documentoNoEncontrado = false;

    public function mount()
    {
        $setting = Setting::first();
        $this->printer_name = $setting->printer_name;
        $this->direct_printing = $setting->direct_printing;
        $this->paymentMethods = PaymentMethod::all();
        $this->boxes = CashRegister::where('status', 'open')->get();
    }

    public function getPaidProperty()
    {
        return collect($this->payments)->sum(fn($p) => (float) ($p['amount'] ?? 0));
    }

    public function getChangeProperty()
    {
        $totalPagadoGeneral = (float)$this->paid;
        $montoADeber = (float)$this->paymentAmount;

        if ($totalPagadoGeneral > $montoADeber) {
            return $totalPagadoGeneral - $montoADeber;
        }

        return 0;
    }

    public function getTotalProperty()
    {
        return (float)$this->subtotal + (float)$this->tax + (float)$this->tip;
    }

    private function calculateTotals($details)
    {
        $this->subtotal = $details->sum('subtotal');
        $this->tax = $details->sum('tax');
        $this->paymentAmount = $this->subtotal + $this->tax + $this->tip;
    }

    public function updatedTip()
    {
        $this->paymentAmount = $this->total;
    }

    public function addPaymentFromSelect()
    {
        if (!$this->selectedMethod) return;

        $exists = collect($this->payments)->pluck('method_id')->contains($this->selectedMethod);
        if ($exists) return;

        $this->payments[] = [
            'method_id' => (int) $this->selectedMethod,
            'amount' => 0,
            'reference' => ''
        ];

        $this->selectedMethod = null;
    }

    public function removePaymentRow($index)
    {
        unset($this->payments[$index]);
        $this->payments = array_values($this->payments);
    }

    public function openSplitPayment($order_id)
    {
        $this->order = Order::with([
            'table',
            'details' => function ($q) {
                $q->where('cooking_status', '!=', 'cancelled');
            }
        ])->find($order_id);

        if (empty($this->selectedDetails)) return;

        $this->detailsToPay = $this->selectedDetails;

        $details = OrderDetail::whereIn('id', $this->selectedDetails)->get();

        $this->calculateTotals($details);

        $this->resetPaymentFields();
    }

    public function openFullPayment($order_id)
    {
        $this->order = Order::with([
            'details' => function ($q) {
                $q->where('cooking_status', '!=', 'cancelled');
            }
        ])->find($order_id);

        $this->detailsToPay = $this->order->details->pluck('id')->toArray();

        $this->calculateTotals($this->order->details);

        $this->resetPaymentFields();
    }

    private function resetPaymentFields()
    {
        $this->payments = [];
        $this->selectedMethod = null;
        $this->tipoComprobante = 'nota_venta';
        $this->clienteTipoDocumento = 'DNI';
        $this->clienteNumeroDocumento = '';
        $this->clienteDenominacion = '';
        $this->clienteDireccion = '';
        $this->buscandoDocumento = false;
        $this->documentoNoEncontrado = false;
        $this->showPaymentModal = true;
    }

    public function setTipoComprobante($tipo)
    {
        $this->tipoComprobante = $tipo;
        $this->clienteTipoDocumento = $tipo === 'factura' ? 'RUC' : 'DNI';
    }

    /**
     * Hook automatico de Livewire: se dispara cada vez que cambia
     * clienteNumeroDocumento (el cajero escribe DNI o RUC).
     * Si el largo coincide (8 = DNI, 11 = RUC) y el servicio esta
     * configurado en Ajustes, autocompleta nombre/razon social.
     * Si falla o no esta configurado, no rompe nada: el cajero sigue
     * pudiendo escribir el nombre a mano como antes.
     */
    public function updatedClienteNumeroDocumento($valor)
    {
        $this->documentoNoEncontrado = false;

        $valor = preg_replace('/\D/', '', (string) $valor);

        $largoEsperado = $this->clienteTipoDocumento === 'RUC' ? 11 : 8;

        if (strlen($valor) !== $largoEsperado) {
            return;
        }

        $this->buscandoDocumento = true;

        try {
            $resultado = (new DocumentoLookupService())->buscar($valor);
        } catch (\Throwable $e) {
            Log::warning('Cajero: fallo al consultar documento', ['error' => $e->getMessage()]);
            $resultado = null;
        }

        $this->buscandoDocumento = false;

        if ($resultado && filled($resultado['denominacion'] ?? null)) {
            $this->clienteDenominacion = $resultado['denominacion'];

            if (filled($resultado['direccion'] ?? null)) {
                $this->clienteDireccion = $resultado['direccion'];
            }
        } else {
            $this->documentoNoEncontrado = true;
        }
    }

    public function processPayment()
    {
        if (in_array($this->tipoComprobante, ['boleta', 'factura'])) {
            $reglas = [
                'clienteNumeroDocumento' => $this->tipoComprobante === 'factura'
                    ? 'required|digits:11'
                    : 'nullable|digits_between:1,15',
                'clienteDenominacion' => $this->tipoComprobante === 'factura'
                    ? 'required|string|max:255'
                    : 'nullable|string|max:255',
            ];

            $mensajes = [
                'clienteNumeroDocumento.required' => 'La factura requiere el RUC del cliente.',
                'clienteNumeroDocumento.digits' => 'El RUC debe tener 11 dígitos.',
                'clienteDenominacion.required' => 'La factura requiere la razón social del cliente.',
            ];

            $this->validate($reglas, $mensajes);
        }

        if (!$this->boxId) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'Debe seleccionar una caja para procesar el pago',
                'icon'  => 'error'
            ]);
            return;
        }

        if (empty($this->payments)) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'Debe agregar al menos un método de pago',
                'icon'  => 'error'
            ]);
            return;
        }

        if (empty($this->detailsToPay)) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'No hay detalles para pagar',
                'icon'  => 'error'
            ]);
            return;
        }

        try {

            DB::beginTransaction();

            $details = OrderDetail::whereIn('id', $this->detailsToPay)->get();

            $subtotal = $details->sum('subtotal');
            $tax = $details->sum('tax');
            $tip = (float)$this->tip;

            $total = $subtotal + $tax + $tip;

            if ($this->paid < $total) {
                DB::rollBack();
                $this->dispatch('swal', [
                    'title' => 'Error',
                    'text'  => 'El monto pagado es insuficiente',
                    'icon'  => 'error'
                ]);
                return;
            }

            $change = $this->paid - $total;
            $remainingChange = $change;

            $sale = Sale::create([
                'order_id' => $this->order->id,
                'cash_register_id' => $this->boxId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'tip' => $tip,
                'total' => $total,
                'paid_amount' => $this->paid,
                'change' => $change,
                'paid_at' => now(),

                'tipo_comprobante' => $this->tipoComprobante,
                'cliente_tipo_documento' => in_array($this->tipoComprobante, ['boleta', 'factura'])
                    ? $this->clienteTipoDocumento
                    : null,
                'cliente_numero_documento' => $this->clienteNumeroDocumento ?: null,
                'cliente_denominacion' => $this->clienteDenominacion ?: null,
                'cliente_direccion' => $this->clienteDireccion ?: null,
                'estado_sunat' => in_array($this->tipoComprobante, ['boleta', 'factura']) ? 'pendiente' : 'no_aplica',
            ]);

            foreach ($details as $detail) {
                $sale->details()->create([
                    'product_id' => $detail->product_id,
                    'product_size_id' => $detail->product_size_id,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->subtotal,
                    'tax' => $detail->tax,
                    'notes' => $detail->notes,
                ]);
            }

            foreach ($this->payments as $payment) {

                $receivedAmount = (float)$payment['amount'];

                if ($receivedAmount <= 0) continue;

                $methodId = (int)$payment['method_id'];

                $method = collect($this->paymentMethods)
                    ->first(fn($m) => (int)$m->id === $methodId);

                $returnedAmount = 0;
                $realAmount = $receivedAmount;

                if ($method && (bool)$method->is_efectivo && $remainingChange > 0) {
                    $returnedAmount = min($receivedAmount, $remainingChange);
                    $realAmount = $receivedAmount - $returnedAmount;
                    $remainingChange -= $returnedAmount;
                }

                $sale->payments()->create([
                    'payment_method_id' => $methodId,
                    'amount' => $realAmount,
                    'received_amount' => $receivedAmount,
                    'returned_amount' => $returnedAmount,
                    'reference' => $payment['reference'] ?? null,
                ]);
            }

            OrderDetail::whereIn('id', $this->detailsToPay)->delete();

            if ($this->order->details()->where('cooking_status', '!=', 'cancelled')->count() === 0) {
                $this->order->update([
                    'status' => 'cerrado',
                    'amount_pending' => 0
                ]);

                $this->order->table->update([
                    'status' => 'libre'
                ]);

                $this->order = null;
            } else {
                $newDetails = $this->order->details()
                    ->where('cooking_status', '!=', 'cancelled')
                    ->get();

                $this->order->update([
                    'amount_pending' => $newDetails->sum('subtotal') + $newDetails->sum('tax')
                ]);

                $this->order->load('details.product');
            }

            CashRegister::find($this->boxId)
                ->increment('current_amount', $total);

            DB::commit();

            $this->showPaymentModal = false;
            $this->selectedDetails = [];

            $message = 'Pago procesado exitosamente.';
            if ($change > 0) {
                $message = 'Entregar vuelto: ' . number_format($change,2);
            }

            $this->dispatch('swal', [
                'title' => 'Venta Exitosa',
                'text'  => $message,
                'icon'  => 'success'
            ]);

            $url = route('sales.receipt', ['id' => $sale->id]);

            if ($this->direct_printing) {
                $url = route('sales.print-local', ['id' => $sale->id]);
            }

            $this->dispatch('print-receipt', [
                'url' => $url,
                'printer_name' => $this->printer_name
            ]);

            if ($sale->requiereSunat()) {
                \App\Jobs\EmitirComprobanteJob::dispatch($sale);
            }

            $this->resetPaymentFields();
            $this->reset(['boxId', 'tip']);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('PAYMENT ERROR', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'No se pudo procesar el pago',
                'icon'  => 'error'
            ]);
        }
    }

    public function render()
    {
        $orders = Order::with([
                'table',
                'details' => function ($q) {
                    $q->where('cooking_status', '!=', 'cancelled')
                        ->with(['product', 'productSize']);
                },
                'user'
            ])
            ->where('status', 'abierto')
            ->whereHas('details', function ($q) {
                $q->where('cooking_status', '!=', 'cancelled');
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->whereHas('table', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.orders-cashier-component', [
            'orders' => $orders
        ]);
    }
}