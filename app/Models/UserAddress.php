<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id','label','address','kelurahan','kecamatan',
        'kota','provinsi','kode_pos','catatan','phone','is_primary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}