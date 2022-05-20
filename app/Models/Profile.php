<?php

namespace App\Models;

use App\Http\Controllers\ProfilesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profileImage()
    {

        $user = \Auth::user();

        if ($this->image) {

            return env('APP_URL') . "/s3avatar/{$user->id}";

        } else {

            return env('APP_URL') . '/images/avatar.png';

        }

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
