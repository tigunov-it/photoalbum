<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use OpenApi\Attributes as OAT;

final class RegisteredUserController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OAT\Post(
        path: '/api/register',
        description: 'Send registration request',
        tags: ['auth'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(required: [
                'name', 'email', 'username', 'password', 'password_confirmation',
            ], properties: [
                new OAT\Property(property: 'name', type: 'string', maxLength: 255),
                new OAT\Property(property: 'email', type: 'string', format: 'email'),
                new OAT\Property(property: 'username', type: 'string', maxLength: 255),
                new OAT\Property(property: 'password', type: 'string', format: 'password'),
                new OAT\Property(property: 'password_confirmation', type: 'string', format: 'password'),
            ]),
        ),
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_NO_CONTENT,
                description: 'Registration successfull',
                content: new OAT\JsonContent(),
            ),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/UnprocessableEntity'),
        ],
    )]
    public function store(Request $request): BaseResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', Rule::unique(User::class)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'password' => [
                'required', 'confirmed',
                Rules\Password::min(8)->letters()->mixedCase()->numbers(),
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
