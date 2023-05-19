<?php

namespace App\Services;

use App\Http\Responses\ImageResponse;
use App\Models\Album;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

final class PostService
{
    public function getPostsByUser(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {

        return QueryBuilderService::addSearchWithPaginate(
            $user->posts(),
            $query,
            'title',
            $perPage,
            $page,
        );
    }

    public function getPublicPostsByUser(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {

        return QueryBuilderService::addSearchWithPaginate(
            $user->publicPosts(),
            $query,
            'title',
            $perPage,
            $page,
        );
    }

    public function getPostsByAlbum(
        Album $album,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {

        return QueryBuilderService::addSearchWithPaginate(
            $album->posts(),
            $query,
            'title',
            $perPage,
            $page,
        );
    }

    /**
     * @param array{
     *  album_id: int,
     *  title?: ?string,
     *  description?: ?string,
     *  image: \Illuminate\Http\UploadedFile,
     * } $data
     */
    public function createPost(User $user, Album $album, array $data): Post
    {
        $albumCreatedAt = Carbon::parse($album->created_at);

        $data['title'] ??= pathinfo($data['image']->getClientOriginalName(), \PATHINFO_FILENAME);
        $data['description'] ??= '';
        $data = array_merge($data, ImageService::uploadPostImage($user, $data['image'], $albumCreatedAt));

        return $user->posts()->create($data);
    }

    /**
     * @param array{
     *  album_id: int,
     *  titles?: array<int, string>,
     *  descriptions?: array<int, string>,
     *  images: array<int, \Illuminate\Http\UploadedFile>,
     * } $data
     */
    public function createPosts(User $user, Album $album, array $data): \Illuminate\Database\Eloquent\Collection
    {
        $albumCreatedAt = Carbon::parse($album->created_at);

        $images = $data['images'];

        foreach ($images as $key => &$image) {
            $image = array_merge([
                'user_id' => $album->user_id,
                'title' => $data['titles'][$key] ?? pathinfo($image->getClientOriginalName(), \PATHINFO_FILENAME),
                'description' => $data['descriptions'][$key] ?? '',
            ], ImageService::uploadPostImage($user, $image, $albumCreatedAt));
        }

        return $album->posts()->createMany($images);
    }

    public function getSmallImageFromS3(Post $post): ImageResponse
    {
        return new ImageResponse(
            ImageService::getImage($post->image_small),
            ImageService::getImageType($post->image_small),
        );
    }

    public function getMediumImageFromS3(Post $post): ImageResponse
    {
        return new ImageResponse(
            ImageService::getImage($post->image_medium),
            ImageService::getImageType($post->image_medium),
        );
    }

    public function getLargeImageFromS3(Post $post): ImageResponse
    {
        return new ImageResponse(
            ImageService::getImage($post->image_large),
            ImageService::getImageType($post->image_large),
        );
    }

    public function getFullImageFromS3(Post $post): ImageResponse
    {
        return new ImageResponse(
            ImageService::getImage($post->image),
            ImageService::getImageType($post->image),
        );
    }

    /**
     * @param array{
     *  album_id?: int,
     *  title?: string,
     *  description?: string,
     * } $data
     */
    public function updatePost(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    public function deletePost(Post $post): ?bool
    {
        ImageService::delete($post->image);
        ImageService::delete($post->image_small);
        ImageService::delete($post->image_medium);
        ImageService::delete($post->image_large);

        return $post->delete();
    }

    /**
     * @param array{
     *  size?: string,
     *  angle?: numeric,
     *  bgcolor?: string,
     * } $data
     */
    public function rotateImage(Post $post, array $data): bool
    {
        $result = ImageService::rotateImage(
            $post->image,
            $data['angle'] ?? 90,
            $data['bgcolor'] ?? '#ffffff',
        );

        ImageService::deleteCache($post->image);
        ImageService::deleteCache($post->image_small);
        ImageService::deleteCache($post->image_medium);
        ImageService::deleteCache($post->image_large);

        return $result === $post->only([
            'image',
            'image_small',
            'image_medium',
            'image_large',
        ]);
    }

    public function share(Post $post): Post
    {
        $post->share_token = (string) Str::orderedUuid();
        $post->share_link = URL::signedRoute('v1.posts.show.shared', ['post' => $post]);
        $post->save();

        return $post;
    }

    public function unshare(Post $post): bool
    {
        return $post->update([
            'share_token' => null,
            'share_link' => null,
        ]);
    }
}
