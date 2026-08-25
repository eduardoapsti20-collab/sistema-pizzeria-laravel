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

        $data = $this->enviarAOperacion($payload);

        if ($data === null) {
            $sale->update([
                'estado_sunat' => 'error',
                'sunat_mensaje' => 'No se pudo conectar con Nubefact.',
            ]);

            return $sale;
        }

        if (isset($data['errors'])) {
            $mensaje = $data['errors'];

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
     * Pide a Nubefact la anulacion (comunicacion de baja) de un comprobante ya
     * aceptado por SUNAT. No borra nada localmente: SUNAT procesa la baja en
     * su siguiente resumen diario, por eso el estado queda "anulacion_solicitada"
     * hasta confirmar. Para facturas, en la practica casi siempre conviene usar
     * una Nota de Credito en vez de esto (ver notaCredito()).
     *
     * IMPORTANTE: verifica el nombre exacto de los campos contra el manual JSON
     * vigente de tu cuenta Nubefact (Ajustes > Api Integracion en su panel)
     * antes de usar esto en produccion; esta es la estructura documentada
     * públicamente para la operacion "generar_anulacion".
     */
    public function anular(Sale $sale, string $motivo): Sale
    {
        if (!$sale->puedeAnularse()) {
            throw new RuntimeException('Esta venta no se puede anular (no es un comprobante aceptado por SUNAT, o ya fue anulada).');
        }

        $payload = [
            'operacion' => 'generar_anulacion',
            'tipo_de_comprobante' => $sale->tipo_comprobante === 'factura' ? 1 : 2,
            'serie' => $sale->comprobante_serie,
            'numero' => $sale->comprobante_numero,
            'motivo' => $motivo,
        ];

        $data = $this->enviarAOperacion($payload);

        if ($data === null || isset($data['errors'])) {
            $mensaje = $data['errors'] ?? 'No se pudo conectar con Nubefact.';

            Log::warning('Nubefact: error al anular', ['sale_id' => $sale->id, 'respuesta' => $data]);

            $sale->update([
                'sunat_mensaje' => is_string($mensaje) ? $mensaje : json_encode($mensaje),
                'sunat_respuesta' => $data,
            ]);

            throw new RuntimeException('Nubefact rechazo la solicitud de anulacion: ' . (is_string($mensaje) ? $mensaje : json_encode($mensaje)));
        }

        $sale->update([
            'estado_sunat' => 'anulacion_solicitada',
            'motivo_anulacion' => $motivo,
            'ticket_anulacion' => $data['ticket'] ?? null,
            'sunat_respuesta' => $data,
        ]);

        return $sale;
    }

    /**
     * Genera una Nota de Credito que referencia a un comprobante ya aceptado.
     * Crea una nueva fila en 'sales' (tipo_comprobante = nota_credito) ligada
     * a la venta original via comprobante_referencia_id, y la envia a Nubefact.
     *
     * $tipoMotivo es el codigo de motivo SUNAT para notas de credito, los mas comunes:
     * 1 = Anulacion de la operacion, 2 = Anulacion por error en el RUC,
     * 3 = Correccion por error en la descripcion, 4 = Descuento global,
     * 5 = Descuento por item, 6 = Devolucion total, 7 = Devolucion por item.
     * Verifica esta tabla contra el manual vigente de Nubefact.
     */
    public function notaCredito(Sale $original, string $motivo, int $tipoMotivo = 6): Sale
    {
        if (!$original->puedeAnularse()) {
            throw new RuntimeException('Solo se puede generar una nota de credito sobre un comprobante ya aceptado por SUNAT.');
        }

        $original->loadMissing('details.product');

        $nota = Sale::create([
            'order_id' => $original->order_id,
            'cash_register_id' => $original->cash_register_id,
            'subtotal' => $original->subtotal,
            'tax' => $original->tax,
            'tip' => 0,
            'total' => $original->total,
            'paid_amount' => 0,
            'change' => 0,
            'paid_at' => now(),
            'tipo_comprobante' => 'nota_credito',
            'cliente_tipo_documento' => $original->cliente_tipo_documento,
            'cliente_numero_documento' => $original->cliente_numero_documento,
            'cliente_denominacion' => $original->cliente_denominacion,
            'cliente_direccion' => $original->cliente_direccion,
            'cliente_email' => $original->cliente_email,
            'comprobante_referencia_id' => $original->id,
            'motivo_anulacion' => $motivo,
            'estado_sunat' => 'pendiente',
        ]);

        foreach ($original->details as $detalle) {
            $nota->details()->create($detalle->only([
                'product_id', 'product_size_id', 'quantity', 'price', 'tax', 'subtotal', 'notes',
            ]));
        }

        $nota->load('details.product');

        $esFacturaOriginal = $original->tipo_comprobante === 'factura';

        $payload = $this->construirPayload($nota->fresh('details.product'));
        $payload['operacion'] = 'generar_comprobante';
        $payload['tipo_de_comprobante'] = 3; // Nota de Credito
        $payload['serie'] = $esFacturaOriginal ? 'FC01' : 'BC01'; // series de notas de credito, confirmar en tu cuenta
        $payload['numero'] = $this->siguienteNumero('nota_credito');
        $payload['sunat_transaction'] = 1;
        $payload['tipo_de_nota_de_credito'] = $tipoMotivo;
        $payload['documento_que_se_modifica_tipo'] = $esFacturaOriginal ? 1 : 2;
        $payload['documento_que_se_modifica_serie'] = $original->comprobante_serie;
        $payload['documento_que_se_modifica_numero'] = $original->comprobante_numero;
        $payload['motivo_de_nota_de_credito'] = $motivo;

        $data = $this->enviarAOperacion($payload);

        if ($data === null || isset($data['errors'])) {
            $mensaje = $data['errors'] ?? 'No se pudo conectar con Nubefact.';

            $nota->update([
                'estado_sunat' => 'error',
                'sunat_mensaje' => is_string($mensaje) ? $mensaje : json_encode($mensaje),
                'sunat_respuesta' => $data,
            ]);

            return $nota;
        }

        $nota->update([
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

        // Si la nota de credito fue aceptada, marcamos el comprobante original como anulado
        if ($nota->estado_sunat === 'aceptado') {
            $original->update([
                'estado_sunat' => 'anulado',
                'motivo_anulacion' => $motivo,
            ]);
        }

        return $nota;
    }

    /**
     * POST generico contra la ruta de Nubefact. Devuelve el JSON decodificado,
     * o null si hubo un problema de conexion (timeout, DNS, etc).
     */
    protected function enviarAOperacion(array $payload): ?array
    {
        try {
            $response = Http::timeout(30)
                ->withToken($this->settings->nubefact_token)
                ->acceptJson()
                ->post($this->settings->nubefact_ruta, $payload);
        } catch (\Throwable $e) {
            Log::error('Nubefact: fallo de conexion', ['operacion' => $payload['operacion'] ?? null, 'error' => $e->getMessage()]);
            return null;
        }

        return $response->json();
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
