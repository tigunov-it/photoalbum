<?php

namespace App\Services;

use App\Models\Album;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class AlbumService
{
    public function getAlbums(User $user, array $data): LengthAwarePaginator
    {
        $builder = $user->albums();

        if (!empty($data['query'])) {
            $builder = QueryBuilderService::addSearchQuery($builder, $data['query'], 'title');
        }

        return $builder->paginate(perPage: $data['per_page'], page: $data['page']);
    }

    public function createAlbum(User $user, array $data): Album
    {
        $now = now();

        $path = ImageService::uploadAlbumImage($user, $data['image'], $now);

        return $user->albums()->forceCreate([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $path,
            'created_at' => $now,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getCoverFromS3(Album $album): StreamedResponse
    {
        return ImageService::getImage($album->image);
    }

    public function deleteAlbum(Album $album): ?bool
    {
        ImageService::deleteFolder(strstr($album->image, '/cover', true));
        return $album->delete();
    }
}
