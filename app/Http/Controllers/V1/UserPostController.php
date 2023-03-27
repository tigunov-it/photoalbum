<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Responses\BaseResponse;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

final class UserPostController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/users/{user_id}/posts',
        summary: 'Display a listing of the public user posts',
        tags: ['users', 'posts'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/user_id'),
            new OAT\Parameter(ref: '#/components/parameters/page'),
            new OAT\Parameter(ref: '#/components/parameters/per_page'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Listing of the public user posts',
            content: new OAT\JsonContent(properties: [
                new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/Post'))
            ]),
        )],
    )]
    public function index(PostIndexRequest $request, User $user, PostService $service): BaseResponse
    {
        $this->authorize('viewAny', Post::class);

        $query = $request->validated('query');
        $perPage = $request->validated('per_page');
        $page = $request->validated('page');

        return new BaseResponse($service->getPublicPostsByUser($user, $query, $perPage, $page));
    }
}
