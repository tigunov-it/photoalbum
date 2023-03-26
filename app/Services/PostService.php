<?php

namespace App\Services;

use App\Models\Album;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PostService
{
    public function getPostsByUser(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {
        $builder = $user->posts();

        if ($query !== null) {
            $builder = QueryBuilderService::addSearchQuery($builder, $query, 'title');
        }

        return $builder->paginate(perPage: $perPage, page: $page);
    }

    public function getPostsByAlbum(
        Album $album,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {
        $builder = $album->posts();

        if ($query !== null) {
            $builder = QueryBuilderService::addSearchQuery($builder, $query, 'title');
        }

        return $builder->paginate(perPage: $perPage, page: $page);
    }

    public function createPosts(User $user, Album $album, array $images): \Illuminate\Database\Eloquent\Collection
    {
        $albumCreatedAt = Carbon::parse($album->created_at);

        foreach ($images as &$image) {
            $image = ImageService::uploadPostImage($user, $image, $albumCreatedAt);
        }

        return $album->posts()->createMany($images);
    }
}
