<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumIndexRequest;
use App\Http\Requests\AlbumStoreRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Http\Responses\AlbumResponse;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\UnsuccessfulResponse;
use App\Models\Album;
use App\Services\AlbumService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $this->authorize('create', Album::class);

        $created = $service->createAlbum($request->user(), $request->validated());

        if ($created) {
            return new AlbumResponse($created, JsonResponse::HTTP_CREATED);
        }

        return new UnsuccessfulResponse;
    }

    #[OAT\Get(
        path: '/api/v1/albums/{album_id}',
        summary: 'Display the specified album',
        tags: ['albums'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/album_id'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Display the specified album',
            content: new OAT\JsonContent(ref: '#/components/schemas/Album'),
        )],
    )]
    public function show(Album $album): BaseResponse
    {
        $this->authorize('view', $album);

        return new AlbumResponse($album);
    }

    #[OAT\Get(
        path: '/api/v1/albums/{album_id}/s3cover',
        summary: 'Display album cover',
        tags: ['albums'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/album_id'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Cover',
            content: new OAT\MediaType(mediaType: 'image/jpeg'),
        )],
    )]
    public function getCoverFromS3(Album $album, AlbumService $service): StreamedResponse
    {
        $this->authorize('view', $album);

        return $service->getCoverFromS3($album);
    }

    #[OAT\Get(
        path: '/api/v1/albums/{album_id}/download-zip',
        summary: 'Download album as ZIP',
        tags: ['albums'],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/album_id'),
        ],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Download as ZIP',
            content: new OAT\MediaType(mediaType: 'application/zip'),
        )],
    )]
    public function downloadZip(Album $album, AlbumService $service): StreamedResponse
    {
        $this->authorize('view', $album);

        return $service->downloadZip($album);
    }

    #[OAT\Post(
        path: '/api/v1/albums/{album_id}',
        summary: 'Update the specified album in storage',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/AlbumUpdateRequest'),
        tags: ['albums'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/album_id')],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_NO_CONTENT,
            description: 'Updated',
            content: new OAT\JsonContent(),
        )],
    )]
    public function update(AlbumUpdateRequest $request, Album $album, AlbumService $service): BaseResponse
    {
        $this->authorize('update', $album);

        $updated = $service->updateAlbum($request->user(), $album, $request->validated());

        if ($updated) {
            return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
        }

        return new BaseResponse(status: JsonResponse::HTTP_BAD_REQUEST);
    }

    #[OAT\Delete(
        path: '/api/v1/albums/{album_id}',
        summary: 'Remove the specified album from storage',
        tags: ['albums'],
        parameters: [new OAT\Parameter(ref: '#/components/parameters/album_id')],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_NO_CONTENT,
            description: 'Deleted',
            content: new OAT\JsonContent(),
        )],
    )]
    public function destroy(Album $album, AlbumService $service): BaseResponse
    {
        $this->authorize('delete', $album);

        $deleted = $service->deleteAlbum($album);

        if ($deleted) {
            return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
        }

        return new BaseResponse(status: JsonResponse::HTTP_BAD_REQUEST);
    }

}
