<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DocumentoLookupService
{
    protected Setting $settings;

    public function __construct(?Setting $settings = null)
    {
        $this->settings = $settings ?? Setting::first();
    }

    public function estaConfigurado(): bool
    {
        return $this->settings && filled($this->settings->documento_api_token);
    }

    /**
     * Consulta un DNI (8 digitos) o RUC (11 digitos) y devuelve
     * ['denominacion' => ..., 'direccion' => ...] o null si no encontro nada
     * o si el servicio no esta configurado / falla.
     *
     * No lanza excepciones: si algo falla, el cajero simplemente sigue
     * escribiendo el nombre a mano, como ya funciona hoy.
     */
    public function buscar(string $numeroDocumento): ?array
    {
        $numeroDocumento = trim($numeroDocumento);

        if (strlen($numeroDocumento) === 8) {
            return $this->buscarDni($numeroDocumento);
        }

        if (strlen($numeroDocumento) === 11) {
            return $this->buscarRuc($numeroDocumento);
        }

        return null;
    }

    /**
     * DNI: primero se intenta con Decolecta (mismo token gratuito que ya se
     * usa para RUC, 1000 consultas/mes gratis, sin costo adicional). Si no
     * esta configurado o no devuelve datos, se intenta con apidni.com como
     * respaldo opcional (solo si el usuario decide pagar ese servicio).
     */
    protected function buscarDni(string $dni): ?array
    {
        $resultado = $this->buscarDniDecolecta($dni);

        if ($resultado) {
            return $resultado;
        }

        return $this->buscarDniApidni($dni);
    }

    protected function buscarDniDecolecta(string $dni): ?array
    {
        if (!$this->settings || !filled($this->settings->documento_api_token)) {
            return null;
        }

        try {
            $response = Http::timeout(6)
                ->withToken($this->settings->documento_api_token)
                ->acceptJson()
                ->get('https://api.decolecta.com/v1/reniec/dni', [
                    'numero' => $dni,
                ]);
        } catch (\Throwable $e) {
            Log::warning('DocumentoLookupService (DNI/Decolecta): fallo de conexion', ['error' => $e->getMessage()]);
            return null;
        }

        if (!$response->successful()) {
            Log::warning('DocumentoLookupService (DNI/Decolecta): respuesta no exitosa', ['status' => $response->status()]);
            return null;
        }

        $data = $response->json();

        if (!is_array($data)) {
            return null;
        }

        // El formato exacto de campos de Decolecta para RENIEC ha variado
        // segun la version de la API, asi que se contemplan varias
        // posibilidades conocidas en vez de asumir una sola.
        $nombre = trim(
            ($data['nombres'] ?? $data['first_name'] ?? '') . ' ' .
            ($data['apellido_paterno'] ?? $data['first_last_name'] ?? '') . ' ' .
            ($data['apellido_materno'] ?? $data['second_last_name'] ?? '')
        );

        if ($nombre === '' && filled($data['full_name'] ?? null)) {
            $nombre = $data['full_name'];
        }

        return $nombre !== '' ? [
            'denominacion' => $nombre,
            'direccion' => $data['direccion'] ?? $data['address'] ?? null,
        ] : null;
    }

    /**
     * Respaldo opcional de pago (apidni.com). Solo se usa si el usuario
     * decide contratar ese servicio y pega su token en Ajustes.
     */
    protected function buscarDniApidni(string $dni): ?array
    {
        if (!$this->settings || !filled($this->settings->dni_api_token)) {
            return null;
        }

        try {
            $response = Http::timeout(6)
                ->withToken($this->settings->dni_api_token)
                ->acceptJson()
                ->get("https://apidni.com/api/v2/dni/{$dni}");
        } catch (\Throwable $e) {
            Log::warning('DocumentoLookupService (DNI/apidni): fallo de conexion', ['error' => $e->getMessage()]);
            return null;
        }

        if (!$response->successful()) {
            Log::warning('DocumentoLookupService (DNI/apidni): respuesta no exitosa', ['status' => $response->status()]);
            return null;
        }

        $body = $response->json();
        $data = $body['data'] ?? null;

        if (!is_array($data)) {
            return null;
        }

        $nombre = trim(
            ($data['nombres'] ?? '') . ' ' .
            ($data['apellido_paterno'] ?? '') . ' ' .
            ($data['apellido_materno'] ?? '')
        );

        return $nombre !== '' ? [
            'denominacion' => $nombre,
            'direccion' => $data['direccion'] ?? null,
        ] : null;
    }

    /**
     * RUC via decolecta.com (la consulta de RUC si sigue disponible publicamente,
     * a diferencia de DNI). Reemplazo del antiguo apis.net.pe.
     */
    protected function buscarRuc(string $ruc): ?array
    {
        if (!$this->settings || !filled($this->settings->documento_api_token)) {
            return null;
        }

        try {
            $response = Http::timeout(6)
                ->withToken($this->settings->documento_api_token)
                ->acceptJson()
                ->get('https://api.decolecta.com/v1/sunat/ruc', [
                    'numero' => $ruc,
                ]);
        } catch (\Throwable $e) {
            Log::warning('DocumentoLookupService (RUC): fallo de conexion', ['error' => $e->getMessage()]);
            return null;
        }

        if (!$response->successful()) {
            Log::warning('DocumentoLookupService (RUC): respuesta no exitosa', ['status' => $response->status()]);
            return null;
        }

        $data = $response->json();

        if (!is_array($data) || empty($data['razon_social'])) {
            return null;
        }

        return [
            'denominacion' => $data['razon_social'],
            'direccion' => $data['direccion'] ?? null,
        ];
    }
}
