<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class NubefactService
{
    protected Setting $settings;

    public function __construct(?Setting $settings = null)
    {
        // Se asume una sola fila de configuracion (como ya usa el resto del sistema)
        $this->settings = $settings ?? Setting::first();

        if (!$this->settings) {
            throw new RuntimeException('No existe configuracion de la empresa (tabla settings vacia).');
        }
    }

    public function estaConfigurado(): bool
    {
        return filled($this->settings->nubefact_ruta) && filled($this->settings->nubefact_token);
    }

    /**
     * Envia una venta (boleta o factura) a Nubefact y actualiza la venta con el resultado.
     * No lanza excepcion si SUNAT/Nubefact rechaza o falla la conexion: en ese caso
     * la venta queda con estado_sunat = 'error' y el mensaje queda guardado.
     */
    public function emitir(Sale $sale): Sale
    {
        if (!$sale->requiereSunat()) {
            throw new RuntimeException('Esta venta es una nota de venta interna, no requiere emision ante SUNAT.');
        }

        if (!$this->estaConfigurado()) {
            $sale->update([
                'estado_sunat' => 'error',
                'sunat_mensaje' => 'Falta configurar la ruta y el token de Nubefact en Ajustes.',
            ]);

            return $sale;
        }

        $sale->loadMissing('details.product');

        $payload = $this->construirPayload($sale);

        try {
            $response = Http::timeout(30)
                ->withToken($this->settings->nubefact_token)
                ->acceptJson()
                ->post($this->settings->nubefact_ruta, $payload);
        } catch (\Throwable $e) {
            Log::error('Nubefact: fallo de conexion', ['sale_id' => $sale->id, 'error' => $e->getMessage()]);

            $sale->update([
                'estado_sunat' => 'error',
                'sunat_mensaje' => 'No se pudo conectar con Nubefact: ' . $e->getMessage(),
            ]);

            return $sale;
        }

        $data = $response->json() ?? [];

        // Nubefact responde 200 incluso ante algunos errores de validacion,
        // por eso revisamos el contenido y no solo el status HTTP.
        if (!$response->successful() || isset($data['errors'])) {
            $mensaje = $data['errors'] ?? ('Error HTTP ' . $response->status());

            Log::warning('Nubefact: rechazo o error', ['sale_id' => $sale->id, 'respuesta' => $data]);

            $sale->update([
                'estado_sunat' => 'error',
                'sunat_mensaje' => is_string($mensaje) ? $mensaje : json_encode($mensaje),
                'sunat_respuesta' => $data,
            ]);

            return $sale;
        }

        $sale->update([
            'estado_sunat' => ($data['aceptada_por_sunat'] ?? false) ? 'aceptado' : 'pendiente',
            'comprobante_serie' => $data['serie'] ?? $payload['serie'],
            'comprobante_numero' => $data['numero'] ?? $payload['numero'],
            'enlace_pdf' => $data['enlace_del_pdf'] ?? null,
            'enlace_xml' => $data['enlace_del_xml'] ?? null,
            'enlace_cdr' => $data['enlace_del_cdr'] ?? null,
            'hash_sunat' => $data['codigo_hash'] ?? null,
            'sunat_mensaje' => $data['sunat_description'] ?? $data['sunat_note'] ?? null,
            'sunat_respuesta' => $data,
        ]);

        return $sale;
    }

    /**
     * Arma el payload JSON que espera la API de Nubefact para generar_comprobante.
     * Referencia: manual de integracion de Nubefact (confirmar campos vigentes
     * en el panel antes de pasar a produccion).
     */
    protected function construirPayload(Sale $sale): array
    {
        $esFactura = $sale->tipo_comprobante === 'factura';

        $siguienteNumero = $this->siguienteNumero($sale->tipo_comprobante);
        $serie = $esFactura
            ? $this->settings->nubefact_serie_factura
            : $this->settings->nubefact_serie_boleta;

        $items = $sale->details->map(function ($detalle) {
            $descripcion = $detalle->product?->name ?? 'Producto';
            $cantidad = (float) $detalle->quantity;
            $valorUnitario = round(((float) $detalle->price) / 1.18, 2); // precio sin IGV
            $igvItem = round(((float) $detalle->price) - $valorUnitario, 2) * $cantidad;

            return [
                'unidad_de_medida' => 'NIU',
                'codigo' => (string) $detalle->product_id,
                'descripcion' => $descripcion,
                'cantidad' => $cantidad,
                'valor_unitario' => $valorUnitario,
                'precio_unitario' => (float) $detalle->price,
                'subtotal' => round($valorUnitario * $cantidad, 2),
                'tipo_de_igv' => 1, // 1 = Gravado - Operacion Onerosa
                'igv' => round($igvItem, 2),
                'total' => (float) $detalle->subtotal,
                'anticipo_regularizacion' => false,
            ];
        })->toArray();

        return [
            'operacion' => 'generar_comprobante',
            'tipo_de_comprobante' => $esFactura ? 1 : 2, // 1 = Factura, 2 = Boleta
            'serie' => $serie,
            'numero' => $siguienteNumero,
            'sunat_transaction' => 1,
            'cliente_tipo_de_documento' => $this->codigoTipoDocumento($sale->cliente_tipo_documento, $esFactura),
            'cliente_numero_de_documento' => $sale->cliente_numero_documento ?: '00000000',
            'cliente_denominacion' => $sale->cliente_denominacion ?: 'Cliente Varios',
            'cliente_direccion' => $sale->cliente_direccion ?: '-',
            'fecha_de_emision' => now()->format('d-m-Y'),
            'moneda' => 1, // 1 = Soles
            'porcentaje_de_igv' => 18.00,
            'total_gravada' => round($sale->subtotal, 2),
            'total_igv' => round($sale->tax, 2),
            'total' => round($sale->total, 2),
            'enviar_automaticamente_a_la_sunat' => true,
            'enviar_automaticamente_al_cliente' => false,
            'items' => $items,
        ];
    }

    /**
     * Nubefact espera codigos SUNAT para el tipo de documento del cliente:
     * 1 = DNI, 6 = RUC, 0 = Sin documento / Varios.
     */
    protected function codigoTipoDocumento(?string $tipo, bool $esFactura): int
    {
        if ($esFactura) {
            return 6; // Factura siempre requiere RUC
        }

        return match ($tipo) {
            'DNI' => 1,
            'RUC' => 6,
            default => 0,
        };
    }

    /**
     * Calcula el siguiente correlativo local para la serie, basandose en el
     * ultimo comprobante emitido de ese tipo. Nubefact tambien lleva su propio
     * correlativo internamente; si llegaran a desincronizarse, Nubefact lo
     * indicara en la respuesta y conviene revisar manualmente.
     */
    protected function siguienteNumero(string $tipoComprobante): int
    {
        $ultimo = Sale::where('tipo_comprobante', $tipoComprobante)
            ->whereNotNull('comprobante_numero')
            ->max('comprobante_numero');

        return ((int) $ultimo) + 1;
    }
}
