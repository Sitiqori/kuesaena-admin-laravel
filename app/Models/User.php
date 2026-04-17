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

    public function getMaskedPhoneAttribute(): string
    {
        if (!$this->phone) return '-';
        $p = $this->phone;
        if (strlen($p) > 6) {
            return substr($p, 0, 4) . str_repeat('*', strlen($p) - 7) . substr($p, -3);
        }
        return $p;
    }
}