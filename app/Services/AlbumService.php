<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class AlbumService
{
    public function getAlbums(User $user, $data): LengthAwarePaginator
    {
        $builder = $user->albums();

        if (!empty($data['query'])) {
            $builder = QueryBuilderService::addSearchQuery($builder, $data['query'], 'title');
        }

        return $builder->paginate();
    }
}
