<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Attributes as OAT;

#[
    OAT\Parameter(
        parameter: 'page',
        name: 'page',
        description: 'Page number',
        in: 'query',
        required: false,
        schema: new OAT\Schema(type: 'integer', minimum: 1),
    ),
    OAT\Parameter(
        parameter: 'per_page',
        name: 'per_page',
        description: 'Number per page',
        in: 'query',
        required: false,
        schema: new OAT\Schema(type: 'integer', minimum: 1),
    ),
    OAT\Parameter(
        parameter: 'query',
        name: 'query',
        description: 'Search query',
        in: 'query',
        required: false,
        schema: new OAT\Schema(type: 'string', maxLength: 255),
    ),
] final class ApiParameter
{
}
