<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'name', 'description', 'type', 'cost_coins',
        'discount_value', 'image', 'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'discount_value' => 'decimal:2',
    ];

    public function redemptions()
    {
        return $this->hasMany(UserRewardRedemption::class);
    }
}
