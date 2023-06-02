<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    properties: [
        new OAT\Property(property: 'id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'user_id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'title', type: 'string', default: null, maxLength: 255, nullable: true),
        new OAT\Property(property: 'description', type: 'string', default: null, maxLength: 16383, nullable: true),
        new OAT\Property(property: 'url', type: 'string', default: null, maxLength: 255, nullable: true),
        new OAT\Property(property: 'image', type: 'string', default: null, maxLength: 255, nullable: true),
        new OAT\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ],
)]
class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'url',
        'image',
    ];

    protected $hidden = [
        'deleted_at',
    ];

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
