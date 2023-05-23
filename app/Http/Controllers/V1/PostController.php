<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\PostRotateRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\ImageResponse;
use App\Http\Responses\SuccessfulResponse;
use App\Http\Responses\UnsuccessfulResponse;
use App\Models\Album;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

final class PostController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/posts',
        summary: 'Display a listing of the posts',
        tags: ['posts'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/page'),
            new OAT\Parameter(ref: '#/components/parameters/per_page'),
            new OAT\Parameter(ref: '#/components/parameters/query'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Listing of the posts',
            content: new OAT\JsonContent(required: ['data'], properties: [
                new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/Post')),
            ]),
        )],
    )]
    public function index(PostIndexRequest $request, PostService $service): BaseResponse
    {
        $this->authorize('viewAny', Post::class);
        [
            'page' => $page,
            'per_page' => $perPage,
            'query' => $query,
        ] = $request->validated();

        return new BaseResponse($service->getPostsByUser($request->user(), $query, $perPage, $page));
    }

    #[OAT\Post(
        path: '/api/v1/posts',
        summary: 'Store a newly created post in storage',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/PostStoreRequest'),
        tags: ['posts'],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_CREATED,
            description: 'Created',
            content: new OAT\JsonContent(ref: '#/components/schemas/Post'),
        )],
    )]
    public function store(PostStoreRequest $request, PostService $service): BaseResponse
    {
        $this->authorize('create', Post::class);

        $album = Album::findOrFail($request->validated('album_id'));

        $this->authorize('update', $album);

        return new BaseResponse(
            $service->createPost($request->user(), $album, $request->validated()),
            JsonResponse::HTTP_CREATED,
        );
    }

    #[OAT\Get(
        path: '/api/v1/posts/{post_id}',
        summary: 'Display the specified post',
        tags: ['posts'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/post_id'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Display the specified post',
            content: new OAT\JsonContent(ref: '#/components/schemas/Post'),
        )],
    )]
    public function show(Post $post): BaseResponse
    {
        $this->authorize('view', $post);

        return new BaseResponse($post);
    }

    #[OAT\Get(
        path: '/api/v1/posts/{post_id}/s3small',
        summary: 'Display post small image',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/ImageResponse')],
    )]
    public function getSmallImageFromS3(Post $post, PostService $service): ImageResponse
    {
        $this->authorize('view', $post);

        return $service->getSmallImageFromS3($post);
    }

    #[OAT\Get(
        path: '/api/v1/posts/{post_id}/s3medium',
        summary: 'Display post medium image',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/ImageResponse')],
    )]
    public function getMediumImageFromS3(Post $post, PostService $service): ImageResponse
    {
        $this->authorize('view', $post);

        return $service->getMediumImageFromS3($post);
    }

    #[OAT\Get(
        path: '/api/v1/posts/{post_id}/s3large',
        summary: 'Display post large image',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/ImageResponse')],
    )]
    public function getLargeImageFromS3(Post $post, PostService $service): ImageResponse
    {
        $this->authorize('view', $post);

        return $service->getLargeImageFromS3($post);
    }

    #[OAT\Get(
        path: '/api/v1/posts/{post_id}/s3full',
        summary: 'Display post full image',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/ImageResponse')],
    )]
    public function getFullImageFromS3(Post $post, PostService $service): ImageResponse
    {
        $this->authorize('view', $post);

        return $service->getFullImageFromS3($post);
    }

    #[OAT\Post(
        path: '/api/v1/posts/{post_id}',
        summary: 'Update the specified post in storage',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/PostUpdateRequest'),
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_NO_CONTENT,
            description: 'Updated',
            content: new OAT\JsonContent(),
        )],
    )]
    public function update(PostUpdateRequest $request, Post $post, PostService $service): BaseResponse
    {
        $this->authorize('update', $post);

        $updated = $service->updatePost($post, $request->validated());

        if ($updated) {
            return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
        }

        return new UnsuccessfulResponse;
    }

    #[OAT\Delete(
        path: '/api/v1/posts/{post_id}',
        summary: 'Remove the specified post from storage',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_NO_CONTENT,
            description: 'Deleted',
            content: new OAT\JsonContent(),
        )],
    )]
    public function destroy(Post $post, PostService $service): BaseResponse
    {
        $this->authorize('delete', $post);

        $deleted = $service->deletePost($post);

        if ($deleted) {
            return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
        }

        return new UnsuccessfulResponse;
    }

    #[OAT\Post(
        path: '/api/v1/posts/{post_id}/rotate',
        summary: 'Rotate and display image',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/PostRotateRequest'),
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [
            new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/SuccessfulResponse'),
            new OAT\Response(response: JsonResponse::HTTP_BAD_REQUEST, ref: '#/components/responses/UnsuccessfulResponse'),
        ],
    )]
    public function rotate(PostRotateRequest $request, Post $post, PostService $service): BaseResponse
    {
        $this->authorize('update', $post);

        return $service->rotateImage($post, $request->validated())
            ? new SuccessfulResponse
            : new UnsuccessfulResponse;
    }

    #[OAT\Get(
        path: '/api/v1/shared/post/{post_share_token}',
        summary: 'Display shared post full image',
        tags: ['posts'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/post_share_token'),
            new OAT\Parameter(ref: '#/components/parameters/signature'),
        ],
        responses: [new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/ImageResponse')],
    )]
    public function showShared(Post $post, PostService $service): ImageResponse
    {
        return $service->getFullImageFromS3($post);
    }

    #[OAT\Post(
        path: '/api/v1/posts/{post_id}/share',
        summary: 'Generate share link',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Shared post',
            content: new OAT\JsonContent(ref: '#/components/schemas/Post'),
        )],
    )]
    public function share(Post $post, PostService $service): BaseResponse
    {
        $this->authorize('update', $post);

        return new BaseResponse($service->share($post));
    }

    #[OAT\Post(
        path: '/api/v1/posts/{post_id}/unshare',
        summary: 'Remove share link',
        tags: ['posts'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/post_id')],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_NO_CONTENT,
            description: 'Removed share link',
            content: new OAT\JsonContent(),
        )],
    )]
    public function unshare(Post $post, PostService $service): BaseResponse
    {
        $this->authorize('update', $post);

        return $service->unshare($post)
            ? new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT)
            : new UnsuccessfulResponse;
    }
}
