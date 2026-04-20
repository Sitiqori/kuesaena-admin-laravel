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
        'stock',
        'min_stock',   // ← tambah ini
        'price',
        'hpp',         // ← tambah ini
        'image',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'hpp'   => 'decimal:2', // ← tambahkan cast juga
        'stock' => 'integer',
        'min_stock' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
