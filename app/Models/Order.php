<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'order_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'delivery_method',
        'size',
        'cake_flavor',
        'notes',
        'scheduled_at',
        'status',
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'tax'          => 'decimal:2',
        'discount'     => 'decimal:2',
        'total'        => 'decimal:2',
        'scheduled_at' => 'datetime',
    ];

    // Status labels & colors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Belum Bayar',
            'processing' => 'Sedang Dikemas',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => '#e67e22',
            'processing' => '#2980b9',
            'completed'  => '#27ae60',
            'cancelled'  => '#c0392b',
            default      => '#7f8c8d',
        };
    }

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate order number
    public static function generateOrderNumber()
    {
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return 'INV-' . $date . '-' . $newNumber;
    }
}