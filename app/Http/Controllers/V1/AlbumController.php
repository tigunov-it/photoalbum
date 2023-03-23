<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumIndexRequest;
use App\Http\Requests\AlbumStoreRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\UnsuccessfullResponse;
use App\Models\Album;
use App\Services\AlbumService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

final class AlbumController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/albums',
        summary: 'Display a listing of the albums',
        tags: ['albums'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/page'),
            new OAT\Parameter(ref: '#/components/parameters/per_page'),
            new OAT\Parameter(ref: '#/components/parameters/query'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Listing of the albums',
            content: new OAT\JsonContent(required: ['data'], properties: [
                new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/Album')),
            ]),
        )],
    )]
    public function index(AlbumIndexRequest $request, AlbumService $service): BaseResponse
    {
        $this->authorize('viewAny', Album::class);

        return new BaseResponse($service->getAlbums($request->user(), $request->validated()));
    }

    #[OAT\Post(
        path: '/api/v1/albums',
        summary: 'Store a newly created album in storage',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/AlbumStoreRequest'),
        tags: ['albums'],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_CREATED,
            description: 'Created',
            content: new OAT\JsonContent(ref: '#/components/schemas/Album'),
        )],
    )]
    public function store(AlbumStoreRequest $request, AlbumService $service): BaseResponse
    {
        $created = $service->createAlbum($request->user(), $request->validated());

        if ($created) {
            return new BaseResponse($created, JsonResponse::HTTP_CREATED);
        }

        return new UnsuccessfullResponse;
    }
}
