<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'tax_id',
        'currency_simbol',
        'logo_path',
        'favicon_path',
        'timezone',
        'direct_printing',
        'separate_orders',
        'printer_name',
        'kitchen_printer_name',
        'social_networks',

        'nubefact_ruta',
        'nubefact_token',
        'nubefact_ambiente',
        'nubefact_serie_boleta',
        'nubefact_serie_factura',
        'regimen_tributario',

        'documento_api_proveedor',
        'documento_api_token',
        'dni_api_token',
    ];

    protected $casts = [
        'social_networks' => 'array',
        'direct_printing' => 'boolean',
        'separate_orders' => 'boolean',
    ];

    /**
     * Helper para obtener la URL del logo
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path 
            ? Storage::url($this->logo_path) 
            : asset('images/logo.png');
    }
}
