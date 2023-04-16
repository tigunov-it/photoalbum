<?php

namespace App\Http\Controllers\Swagger;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

#[
    OAT\Schema(schema: 'ValidationErrors', required: ['message', 'errors'], properties: [
        new OAT\Property(property: 'message', type: 'string'),
        new OAT\Property(property: 'errors', type: 'object', example: ['field' => ['message']]),
    ]),
    OAT\Response(
        response: 'UnprocessableEntity',
        description: 'Validation errors',
        content: new OAT\JsonContent(ref: '#/components/schemas/ValidationErrors'),
    ),
] final class ApiResponse
{
}
