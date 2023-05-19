<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Attributes as OAT;

#[
    OAT\Parameter(
        parameter: 'album_id',
        name: 'album_id',
        description: 'Album ID',
        in: 'path',
        required: true,
        schema: new OAT\Schema(type: 'integer', format: 'int64', minimum: 1),
    ),
    OAT\Parameter(
        parameter: 'post_id',
        name: 'post_id',
        description: 'Post ID',
        in: 'path',
        required: true,
        schema: new OAT\Schema(type: 'integer', format: 'int64', minimum: 1),
    ),
    OAT\Parameter(
        parameter: 'post_share_token',
        name: 'post_share_token',
        description: 'Post share token',
        in: 'path',
        required: true,
        schema: new OAT\Schema(type: 'string', format: 'uuid'),
    ),
    OAT\Parameter(
        parameter: 'signature',
        name: 'signature',
        description: 'Signature',
        in: 'query',
        required: true,
        schema: new OAT\Schema(type: 'string', maxLength: 64, minLength: 64),
    ),
    OAT\Parameter(
        parameter: 'user_id',
        name: 'user_id',
        description: 'User ID',
        in: 'path',
        required: true,
        schema: new OAT\Schema(type: 'integer', format: 'int64', minimum: 1),
    ),
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
