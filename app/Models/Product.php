<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'status',
        'image',
        'requires_kitchen'
    ];

    protected $casts = [
        'requires_kitchen' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // AGREGADO: tamaños/precios variables del producto (Familiar, Grande, XL, etc.)
    // Si el producto no tiene tamaños, esta relación simplemente viene vacía
    // y se usa el campo `price` normal.
    public function sizes()
    {
        return $this->hasMany(ProductSize::class)->orderBy('order');
    }

    // AGREGADO: helper para saber rápido si el producto usa tamaños o precio único
    public function hasSizes(): bool
    {
        return $this->sizes->isNotEmpty();
    }
}