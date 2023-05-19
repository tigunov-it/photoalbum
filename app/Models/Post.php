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
        new OAT\Property(property: 'title', type: 'string', default: '', maxLength: 255, nullable: true),
        new OAT\Property(property: 'description', type: 'string', default: '', maxLength: 16383, nullable: true),
        new OAT\Property(property: 'image', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image_small', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image_medium', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image_large', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'share_token', type: 'string', format: 'uuid', nullable: true),
        new OAT\Property(property: 'share_link', type: 'string', maxLength: 255, nullable: true),
        new OAT\Property(property: 'exif', type: 'object'),
    ],
)]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'title',
        'description',
        'image',
        'image_small',
        'image_medium',
        'image_large',
        'share_token',
        'share_link',
        'exif',
    ];

    protected $casts = [
        'exif' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
