<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

#[OAT\Response(
    response: 'AlbumResponse',
    description: 'Album response',
    content: new OAT\JsonContent(allOf: [
        new OAT\Schema(ref: '#/components/schemas/Album'),
        new OAT\Schema(properties: [
            new OAT\Property(property: 'posts_count', type: 'integer', minimum: 0),
        ]),
    ]),
)]
final class AlbumResponse extends BaseResponse
{
    public function toResponse($request): JsonResponse
    {
        $album = $this->data;
        /** @var \App\Models\Album $album */

        return new JsonResponse(
            data: array_merge($album->toArray(), [
                'posts_count' => $album->posts()->count(),
            ]),
            status: $this->status,
        );
    }
}
