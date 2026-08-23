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
        'sale_code'
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
}