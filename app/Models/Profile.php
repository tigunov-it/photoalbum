<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profileImage()
    {
//        $imagePath = ($this->image) ? $this->image : '/profile/avatar.png';
        $imagePath = ($this->image) ? $this->image : env('APP_URL') . '/images/avatar.png';
        return $imagePath;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
