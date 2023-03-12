<?php

namespace App\Http\Controllers\Sanctum;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OAT;

class ApiTokenController extends Controller
{
    #[OAT\Post(
        path: '/api/sanctum/token',
        description: 'Generate Sanctum Token',
        tags: ['sanctum'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(required: ['email', 'password', 'device_name'], properties: [
                new OAT\Property(property: 'email', type: 'string', format: 'email'),
                new OAT\Property(property: 'password', type: 'string', format: 'password'),
                new OAT\Property(property: 'device_name', type: 'string', example: 'phone'),
            ]),
        ),
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_OK,
                description: 'Sanctum Token with ID',
                content: new OAT\JsonContent(type: 'string', description: 'id|token', example: '1|token'),
            ),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/UnprocessableEntity'),
        ],
    )]
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return new JsonResponse($user->createToken($request->device_name)->plainTextToken);
    }
}
