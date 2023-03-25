<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    properties: [
        new OAT\Property(property: 'id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'user_id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'title', type: 'string', maxLength: 255),
        new OAT\Property(property: 'description', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'image', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'is_default', type: 'boolean', default: false),
    ],
)]
class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }
}
