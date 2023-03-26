<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Responses\BaseResponse;
use App\Models\Album;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

final class AlbumPostController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/albums/{album_id}/posts',
        summary: 'Display a listing of the album posts',
        tags: ['albums', 'posts'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/album_id'),
            new OAT\Parameter(ref: '#/components/parameters/page'),
            new OAT\Parameter(ref: '#/components/parameters/per_page'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Listing of the album posts',
            content: new OAT\JsonContent(properties: [
                new OAT\Property(property: 'data', type: 'array', items: new OAT\Items(ref: '#/components/schemas/Post'))
            ]),
        )],
    )]
    public function index(PostIndexRequest $request, Album $album, PostService $service): BaseResponse
    {
        $this->authorize('view', $album);

        $query = $request->validated('query');
        $perPage = $request->validated('per_page');
        $page = $request->validated('page');

        return new BaseResponse($service->getPostsByAlbum($album, $query, $perPage, $page));
    }
}
