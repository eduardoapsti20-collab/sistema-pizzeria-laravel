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

            // No se relanza la excepcion: con QUEUE_CONNECTION=sync, el job
            // corre en el mismo request del cobro, y un fallo de Nubefact
            // (caida de red, timeout, rechazo) nunca debe romper el cobro
            // ya confirmado en caja. NubefactService ya deja la venta en
            // estado_sunat='error' en casi todos los casos; esto es una
            // red de seguridad final por si el error ocurrio antes de eso.
            if ($this->sale->fresh()->estado_sunat !== 'error') {
                $this->sale->update([
                    'estado_sunat' => 'error',
                    'sunat_mensaje' => 'Error inesperado al emitir: ' . $e->getMessage(),
                ]);
            }
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
