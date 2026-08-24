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

        if (!$this->estaConfigurado()) {
            return null;
        }

        if (strlen($numeroDocumento) === 8) {
            return $this->buscarDni($numeroDocumento);
        }

        if (strlen($numeroDocumento) === 11) {
            return $this->buscarRuc($numeroDocumento);
        }

        return null;
    }

    protected function buscarDni(string $dni): ?array
    {
        return $this->consultar("https://api.apis.net.pe/v2/reniec/dni", [
            'numero' => $dni,
        ], function (array $data) {
            $nombre = trim(
                ($data['nombres'] ?? '') . ' ' .
                ($data['apellidoPaterno'] ?? '') . ' ' .
                ($data['apellidoMaterno'] ?? '')
            );

            return $nombre !== '' ? [
                'denominacion' => $nombre,
                'direccion' => null,
            ] : null;
        });
    }

    protected function buscarRuc(string $ruc): ?array
    {
        return $this->consultar("https://api.apis.net.pe/v2/sunat/ruc", [
            'numero' => $ruc,
        ], function (array $data) {
            $razonSocial = $data['nombre'] ?? $data['razonSocial'] ?? null;

            return $razonSocial ? [
                'denominacion' => $razonSocial,
                'direccion' => $data['direccion'] ?? null,
            ] : null;
        });
    }

    protected function consultar(string $url, array $query, callable $mapear): ?array
    {
        try {
            $response = Http::timeout(6)
                ->withToken($this->settings->documento_api_token)
                ->acceptJson()
                ->get($url, $query);
        } catch (\Throwable $e) {
            Log::warning('DocumentoLookupService: fallo de conexion', ['error' => $e->getMessage()]);
            return null;
        }

        if (!$response->successful()) {
            Log::warning('DocumentoLookupService: respuesta no exitosa', [
                'status' => $response->status(),
                'url' => $url,
            ]);
            return null;
        }

        $data = $response->json();

        if (!is_array($data)) {
            return null;
        }

        return $mapear($data);
    }
}
