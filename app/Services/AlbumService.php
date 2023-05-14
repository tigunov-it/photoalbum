<?php

namespace App\Services;

use App\Http\Responses\ImageResponse;
use App\Models\Album;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class AlbumService
{
    public function getAlbums(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {

        return QueryBuilderService::addSearchWithPaginate(
            $user->albums()->withCount('posts'),
            $query,
            'title',
            $perPage,
            $page,
        );
    }

    public function getPublicAlbumsByUser(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {

        return QueryBuilderService::addSearchWithPaginate(
            $user->publicAlbums()->withCount('posts'),
            $query,
            'title',
            $perPage,
            $page,
        );
    }

    /**
     * @param array{
     *  title: string,
     *  description: string,
     *  image: \Illuminate\Http\UploadedFile,
     *  is_public?: bool,
     * } $data
     */
    public function createAlbum(User $user, array $data): Album
    {
        $data['created_at'] = now();
        $data['image'] = ImageService::uploadAlbumImage($user, $data['image'], $data['created_at']);

        return $user->albums()->forceCreate($data);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getCoverFromS3(Album $album): ImageResponse
    {
        return new ImageResponse(
            ImageService::getImage($album->image),
            ImageService::getImageType($album->image),
        );
    }

    public function downloadZip(Album $album): StreamedResponse
    {
        return ImageService::downloadZip(Carbon::parse($album->created_at));
    }

    /**
     * @param array{
     *  title?: string,
     *  description?: string,
     *  image?: \Illuminate\Http\UploadedFile,
     *  is_public?: bool,
     * } $data
     */
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
        ImageService::deleteFolder(strstr((string) $album->image, '/cover', true));

        $postService = app(PostService::class);

        foreach ($album->posts as $post) {
            $postService->deletePost($post);
        }

        return $album->delete();
    }
}
