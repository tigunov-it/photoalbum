<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    properties: [
        new OAT\Property(property: 'id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'user_id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'album_id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'title', type: 'string', maxLength: 255),
        new OAT\Property(property: 'description', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image_small', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image_medium', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image_large', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ],
)]
class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
