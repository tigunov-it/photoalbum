<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Attributes as OAT;

#[
    OAT\Response(
        response: 'UnprocessableEntity',
        description: 'Validation messages',
        content: new OAT\JsonContent(type: 'array', items: new OAT\Items(properties: [
            new OAT\Property(property: 'message', type: 'string'),
            new OAT\Property(property: 'errors', type: 'object'),
        ])),
    ),
] final class ApiResponse
{
}
