<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

#[OAT\Response(
    response: 'UnsuccessfulResponse',
    description: 'Unsuccessful Response',
    content: new OAT\JsonContent(
        required: ['message'],
        properties: [
            new OAT\Property(property: 'message', type: 'string', example: 'Operation failed'),
        ],
    ),
)]
final class UnsuccessfulResponse extends BaseResponse implements Responsable
{
    public function __construct(
        ?string $data = null,
        ?int $status  = null,
    ) {
        parent::__construct(
            $data   ?? __('Operation failed'),
            $status ?? JsonResponse::HTTP_BAD_REQUEST,
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
