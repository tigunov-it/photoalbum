<?php

namespace App\Services;

use App\Models\Album;
use App\Models\User;
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


}
