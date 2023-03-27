<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class PostService
{
    /**
     * TODO: not implemented
     */
    public function getPublicPostsByUser(
        User $user,
        ?string $query = null,
        ?int $perPage = null,
        ?int $page = null,
    ): LengthAwarePaginator {
        return $this->getPostsByUser($user, $query, $perPage, $page);
    }

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

    public function createPosts(User $user, Album $album, array $data): \Illuminate\Database\Eloquent\Collection
    {
        $albumCreatedAt = Carbon::parse($album->created_at);

        $images = $data['images'];

        foreach ($images as $key => &$image) {
            $image = array_merge([
                'user_id' => $album->user_id,
                'title' => $data['titles'][$key] ?? '',
                'description' => $data['descriptions'][$key] ?? '',
            ], ImageService::uploadPostImage($user, $image, $albumCreatedAt));
        }

        return $album->posts()->createMany($images);
    }

    public function getSmallImageFromS3(Post $post): StreamedResponse
    {
        return ImageService::getImage($post->image_small);
    }

    public function getMediumImageFromS3(Post $post): StreamedResponse
    {
        return ImageService::getImage($post->image_medium);
    }

    public function getLargeImageFromS3(Post $post): StreamedResponse
    {
        return ImageService::getImage($post->image_large);
    }

    public function getFullImageFromS3(Post $post): StreamedResponse
    {
        return ImageService::getImage($post->image);
    }

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
}
