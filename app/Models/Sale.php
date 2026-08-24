<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'order_id',
        'cash_register_id',
        'subtotal',
        'tax',
        'tip',
        'total',
        'paid_amount',
        'change',
        'paid_at',
        'sale_code',

        'tipo_comprobante',
        'cliente_tipo_documento',
        'cliente_numero_documento',
        'cliente_denominacion',
        'cliente_direccion',
        'comprobante_serie',
        'comprobante_numero',
        'estado_sunat',
        'enlace_pdf',
        'enlace_xml',
        'enlace_cdr',
        'hash_sunat',
        'sunat_mensaje',
        'sunat_respuesta',
        'comprobante_referencia_id',
    ];

    protected $casts = [
        'sunat_respuesta' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($sale) {
            $sale->update([
                'sale_code' => 'VT-' . str_pad($sale->id, 3, '0', STR_PAD_LEFT)
            ]);
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Comprobante original al que hace referencia esta venta
     * (usado por notas de credito/debito, se conecta en la Fase 4).
     */
    public function comprobanteReferencia()
    {
        return $this->belongsTo(Sale::class, 'comprobante_referencia_id');
    }

    /**
     * Ventas (notas de credito/debito) que referencian a esta.
     */
    public function comprobantesRelacionados()
    {
        return $this->hasMany(Sale::class, 'comprobante_referencia_id');
    }

    public function requiereSunat(): bool
    {
        return in_array($this->tipo_comprobante, ['boleta', 'factura']);
    }

    public function comprobanteAceptado(): bool
    {
        return $this->estado_sunat === 'aceptado';
    }

    /**
     * Nombre completo del comprobante, ej: "B001-000123"
     */
    public function getNumeroCompletoAttribute(): ?string
    {
        if (!$this->comprobante_serie || !$this->comprobante_numero) {
            return null;
        }

        return $this->comprobante_serie . '-' . str_pad($this->comprobante_numero, 6, '0', STR_PAD_LEFT);
    }
}