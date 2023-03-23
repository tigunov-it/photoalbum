<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OAT;

final class AuthenticatedSessionController extends Controller
{
    #[OAT\Post(
        path: '/api/v1/login',
        description: 'Send authentication request',
        tags: ['auth'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(required: ['email', 'password'], properties: [
                new OAT\Property(property: 'email', type: 'string', format: 'email'),
                new OAT\Property(property: 'password', type: 'string', format: 'password'),
                new OAT\Property(property: 'remember', type: 'boolean', default: false),
            ]),
        ),
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_NO_CONTENT,
                description: 'Authentication successful',
                content: new OAT\JsonContent(),
            ),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/UnprocessableEntity'),
        ],
    )]
    public function store(LoginRequest $request): BaseResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }

    #[OAT\Post(
        path: '/api/v1/logout',
        description: 'Destroy an authenticated session',
        tags: ['auth'],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_NO_CONTENT,
                description: 'Logout successful',
                content: new OAT\JsonContent(),
            ),
        ],
    )]
    public function destroy(Request $request): BaseResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
