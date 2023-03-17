<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

#[OAT\Response(
    response: 'SuccessfullResponse',
    description: 'Successfull Response',
    content: new OAT\JsonContent(
        required: ['message'],
        properties: [
            new OAT\Property(property: 'message', type: 'string', example: 'Operation completed successfully'),
        ],
    ),
)]
final class SuccessfullResponse extends BaseResponse implements Responsable
{
    public function __construct(
        ?string $data = null,
        ?int $status  = null,
    ) {
        return parent::__construct(
            $data   ?? __('Operation completed successfully'),
            $status ?? JsonResponse::HTTP_OK,
        );
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: ['message' => $this->data],
            status: $this->status,
        );
    }
}
