<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'code',
        'unit',
        'stock',
        'min_stock',
        'price',
        'hpp',
        'image',
        'description',
        'has_size',
        'price_s',
        'price_m',
        'price_l',
        'price_xl',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'hpp'      => 'decimal:2',
        'price_s'  => 'decimal:2',
        'price_m'  => 'decimal:2',
        'price_l'  => 'decimal:2',
        'price_xl' => 'decimal:2',
        'stock'    => 'integer',
        'min_stock'=> 'integer',
        'has_size' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}