<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRewardRedemption extends Model
{
    protected $fillable = ['user_id', 'reward_id', 'code', 'status', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
