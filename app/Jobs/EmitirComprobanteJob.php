<?php

namespace App\Jobs;

use App\Models\Sale;
use App\Services\NubefactService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EmitirComprobanteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [10, 30, 60]; // segundos entre reintentos automaticos

    public function __construct(public Sale $sale)
    {
    }

    public function handle(NubefactService $nubefact): void
    {
        if (!$this->sale->requiereSunat()) {
            return;
        }

        // Si ya quedo aceptado (por un reintento manual mientras el job esperaba
        // en cola), no hace falta volver a emitir.
        if ($this->sale->fresh()->estado_sunat === 'aceptado') {
            return;
        }

        try {
            $nubefact->emitir($this->sale);
        } catch (\Throwable $e) {
            Log::error('EmitirComprobanteJob: error inesperado', [
                'sale_id' => $this->sale->id,
                'error' => $e->getMessage(),
            ]);

            // Dejamos que Laravel reintente segun $tries/$backoff antes de
            // marcar el job como fallido definitivamente.
            throw $e;
        }
    }

    /**
     * Se ejecuta cuando ya se agotaron todos los reintentos automaticos.
     * La venta queda visible como error en la lista, con boton de
     * reintento manual (ya implementado en SalesIndexComponent).
     */
    public function failed(\Throwable $exception): void
    {
        $this->sale->update([
            'estado_sunat' => 'error',
            'sunat_mensaje' => 'Fallo tras varios intentos automaticos: ' . $exception->getMessage(),
        ]);
    }
}
