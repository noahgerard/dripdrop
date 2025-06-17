<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'comment_id',
        'coffee_id',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

    public function post()
    {
        return $this->belongsTo(Coffee::class, 'coffee_id');
    }
}
