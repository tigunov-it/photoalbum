<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResponse implements Responsable
{
    public function __construct(
        protected readonly Collection|JsonResource|Model|array|string|null $data   = null,
        protected readonly int                                             $status = JsonResponse::HTTP_OK,
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
