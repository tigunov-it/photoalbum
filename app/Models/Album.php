<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        new OAT\Property(property: 'is_public', type: 'boolean', default: false),
    ],
)]
class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_public',
    ];

    public function user(): BelongsTo|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }
}
