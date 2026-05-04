<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // ... fillable, casts, dll ...

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function likes()
    {
        return $this->hasMany(ProductLike::class);
    }

    public function getLikeCountAttribute()
    {
        return $this->likes()->count();
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function isInWishlistByUser($userId)
    {
        return $this->wishlists()->where('user_id', $userId)->exists();
    }

    // 👇 TAMBAHKAN INI 👇
    public function isInCart()
    {
        if (!auth()->check()) return false;
        return auth()->user()->carts()->where('product_id', $this->id)->exists();
    }
    // 👆 SAMPAI SINI 👆
}