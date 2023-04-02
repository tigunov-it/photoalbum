<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    properties: [
        new OAT\Property(property: 'id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'name', type: 'string', maxLength: 255),
        new OAT\Property(property: 'email', type: 'string', format: 'email'),
        new OAT\Property(property: 'username', type: 'string', maxLength: 255),
        new OAT\Property(property: 'email_verified_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ],
)]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(static function (User $user): void {
            $user->profile()->create([
                'title' => $user->username,
            ]);
            $user->albums()->forceCreate([
                'title' => 'Unsorted',
                'description' => '',
                'image' => '',
                'is_default' => true,
            ]);
        });
    }

    public function posts(): HasMany|Builder|\Illuminate\Database\Query\Builder
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function publicPosts(): HasMany|Builder|\Illuminate\Database\Query\Builder
    {
        return $this->posts()->whereHas(
            'album',
            static fn (Builder $query): Builder => $query->where('is_public', '=', true),
        );
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function albums(): HasMany|Builder|\Illuminate\Database\Query\Builder
    {
        return $this->hasMany(Album::class)->orderBy('created_at', 'DESC');
    }

    public function defaultAlbum(): HasOne|Builder|\Illuminate\Database\Query\Builder
    {
        return $this->hasOne(Album::class)->where('is_default', '=', true);
    }

    public function publicAlbums(): HasMany|Builder|\Illuminate\Database\Query\Builder
    {
        return $this->albums()->where('is_public', '=', true);
    }
}
