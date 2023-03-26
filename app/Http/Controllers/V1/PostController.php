<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\UnsuccessfullResponse;
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

        $query = $request->validated('query');
        $perPage = $request->validated('per_page');
        $page = $request->validated('page');

        return new BaseResponse($service->getPostsByUser($request->user(), $query, $perPage, $page));
    }

    #[OAT\Post(
        path: '/api/v1/posts',
        summary: 'Store a newly created posts in storage',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/PostStoreRequest'),
        tags: ['posts'],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_CREATED,
            description: 'Created',
            content: new OAT\JsonContent(type: 'array', items: new OAT\Items(ref: '#/components/schemas/Post')),
        )],
    )]
    public function store(PostStoreRequest $request, PostService $service): BaseResponse
    {
        $this->authorize('create', Post::class);

        $album = Album::findOrFail($request->validated('album_id'));

        $created = $service->createPosts($request->user(), $album, $request->validated('images'));

        if ($created) {
            return new BaseResponse($created, JsonResponse::HTTP_CREATED);
        }

        return new UnsuccessfullResponse;
    }
}
