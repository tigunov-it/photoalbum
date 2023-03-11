<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }
}
