<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_size_id',
        'quantity',
        'requires_kitchen',
        'price',
        'tax',
        'subtotal',
        'notes',
        'cooking_status',
        'is_printed'
    ];

    protected $casts = [
        'requires_kitchen' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // AGREGADO: tamaño elegido (Familiar/Grande/XL). Viene NULL en
    // productos de precio único, así que siempre hay que comprobar
    // si existe antes de mostrarlo.
    public function productSize()
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }
}