<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class AlbumResponse extends BaseResponse
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
