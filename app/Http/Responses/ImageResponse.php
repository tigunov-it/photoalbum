<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use OpenApi\Attributes as OAT;

#[OAT\Response(
    response: 'ImageResponse',
    description: 'Image response',
    content: new OAT\MediaType(mediaType: 'image/*'),
)]
final class ImageResponse implements Responsable
{
    public function __construct(
        protected readonly string $image,
        protected readonly string|false $mimeType,
        protected readonly int $status = Response::HTTP_OK,
    ) {
    }

    public function toResponse($request): Response
    {
        return new Response(
            $this->image,
            $this->status,
            ['Content-Type' => $this->mimeType],
        );
    }
}
