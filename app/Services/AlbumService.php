<?php

namespace App\Services;

use App\Models\Album;
use App\Models\User;
use Carbon\Carbon;
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

    public function getPublicAlbumsByUser(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {
        $builder = $user->publicAlbums();

        if ($query !== null) {
            $builder = QueryBuilderService::addSearchQuery($builder, $query, 'title');
        }

        return $builder->paginate(perPage: $perPage, page: $page);
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

    public function downloadZip(Album $album): StreamedResponse
    {
        return ImageService::downloadZip(Carbon::parse($album->created_at));
    }

    public function updateAlbum(User $user, Album $album, array $data): bool
    {
        if (!empty($data['image'])) {

            if ($album->image !== null) {
                ImageService::delete($album->image);
            }

            $data['image'] = ImageService::uploadAlbumImage($user, $data['image'], Carbon::parse($album->created_at));
        }

        return $album->update($data);
    }

    public function deleteAlbum(Album $album): ?bool
    {
        ImageService::deleteFolder(strstr($album->image, '/cover', true));

        $postService = app(PostService::class);

        foreach ($album->posts as $post) {
            $postService->deletePost($post);
        }

        return $album->delete();
    }
}
