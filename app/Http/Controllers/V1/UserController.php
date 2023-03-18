<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

final class UserController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/user',
        tags: ['user'],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_OK,
                description: 'user',
                content: new OAT\JsonContent(ref: '#/components/schemas/User'),
            ),
        ],
    )]
    public function user(Request $request): BaseResponse
    {
        return new BaseResponse($request->user());
    }
}
