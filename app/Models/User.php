<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'is_active', 'office',
        'phone', 'birth_date', 'gender', 'photo',
        'notif_whatsapp', 'notif_pesanan', 'notif_promo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'birth_date'        => 'date',
            'notif_whatsapp'    => 'boolean',
            'notif_pesanan'     => 'boolean',
            'notif_promo'       => 'boolean',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function coinRecord()
    {
        return $this->hasOne(UserCoin::class);
    }

    public function redemptions()
    {
        return $this->hasMany(UserRewardRedemption::class);
    }


// app/Models/User.php

// Wishlist & Like relations
public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}

public function productLikes()
{
    return $this->hasMany(ProductLike::class);
}

// Cek apakah user sudah like product tertentu
public function hasLiked($productId)
{
    return $this->productLikes()->where('product_id', $productId)->exists();
}

// Cek apakah user sudah wishlist product tertentu  
public function hasWishlisted($productId)
{
    return $this->wishlists()->where('product_id', $productId)->exists();
}

// Toggle like (simpan ke database)
public function toggleLike($productId)
{
    $like = $this->productLikes()->where('product_id', $productId);
    
    if ($like->exists()) {
        $like->delete();
        return false; // Sudah unlike
    } else {
        $this->productLikes()->create([
            'product_id' => $productId
        ]);
        return true; // Sudah like
    }
}

// Toggle wishlist (simpan ke database)
public function toggleWishlist($productId)
{
    $wishlist = $this->wishlists()->where('product_id', $productId);
    
    if ($wishlist->exists()) {
        $wishlist->delete();
        return false; // Sudah dihapus dari wishlist
    } else {
        $this->wishlists()->create([
            'product_id' => $productId
        ]);
        return true; // Sudah ditambahkan ke wishlist
    }
}

// Helpers
public function getMaskedPhoneAttribute(): string
{
    if (!$this->phone) return '-';
    $p = $this->phone;
    if (strlen($p) > 6) {
        return substr($p, 0, 4) . str_repeat('*', strlen($p) - 6) . substr($p, -2);
    }
    return $p;
}


}
