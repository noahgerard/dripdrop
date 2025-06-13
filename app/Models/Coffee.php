<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coffee extends Model
{
    protected $fillable = [
        'user_id',
        'consumed_at',
        'is_custom',
        'title',
        'desc',
        'img_url',
        'del_img_url',
        'type',
    ];

    protected $casts = [
        'consumed_at' => 'datetime',
        'is_custom' => 'bool'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
