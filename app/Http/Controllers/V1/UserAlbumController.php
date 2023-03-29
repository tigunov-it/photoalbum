<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumIndexRequest;
use App\Http\Responses\BaseResponse;
use App\Models\Album;
use App\Models\User;
use App\Services\AlbumService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

final class UserAlbumController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/users/{user_id}/albums',
        summary: 'Display a listing of the public user albums',
        tags: ['users', 'albums'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/user_id'),
            new OAT\Parameter(ref: '#/components/parameters/query'),
            new OAT\Parameter(ref: '#/components/parameters/per_page'),
            new OAT\Parameter(ref: '#/components/parameters/page'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Listing of the public user albums',
            content: new OAT\JsonContent(properties: [
                new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/Album'))
            ]),
        )],
    )]
    public function index(AlbumIndexRequest $request, User $user, AlbumService $service): BaseResponse
    {
        $this->authorize('viewAny', Album::class);

        $query = $request->validated('query');
        $perPage = $request->validated('per_page');
        $page = $request->validated('page');

        return new BaseResponse($service->getPublicAlbumsByUser($user, $query, $perPage, $page));
    }
}
