<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'body',
        'icon', 'color', 'action_url', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Icon & color defaults per type
    public static function defaults(string $type): array
    {
        return match($type) {
            'pesanan'   => ['icon' => 'fa-clipboard-list', 'color' => '#2980b9'],
            'promo'     => ['icon' => 'fa-tag',            'color' => '#e67e22'],
            'whatsapp'  => ['icon' => 'fa-whatsapp',       'color' => '#25D366'],
            default     => ['icon' => 'fa-bell',           'color' => '#7B3F18'],
        };
    }
}
