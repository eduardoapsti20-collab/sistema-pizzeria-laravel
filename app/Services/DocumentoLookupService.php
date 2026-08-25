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
        return $this->settings && (filled($this->settings->documento_api_token) || filled($this->settings->dni_api_token));
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
     * DNI via apidni.com. La consulta publica gratuita de apis.net.pe/decolecta
     * fue descontinuada (normativa de proteccion de datos personales), asi que
     * DNI usa un proveedor de pago aparte, con su propio token.
     */
    protected function buscarDni(string $dni): ?array
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
            Log::warning('DocumentoLookupService (DNI): fallo de conexion', ['error' => $e->getMessage()]);
            return null;
        }

        if (!$response->successful()) {
            Log::warning('DocumentoLookupService (DNI): respuesta no exitosa', ['status' => $response->status()]);
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
