<?php

namespace App\Http\Responses;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;

class BaseResponse implements Responsable
{
    public function __construct(
        protected readonly Arrayable|ArrayAccess|Jsonable|JsonSerializable|array|string|null $data = null,
        protected readonly int                                                             $status = JsonResponse::HTTP_OK,
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status,
        );
    }
}
