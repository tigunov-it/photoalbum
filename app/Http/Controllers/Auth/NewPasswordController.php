<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OAT;

final class NewPasswordController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OAT\Post(
        path: '/api/reset-password',
        description: 'Send new password request',
        tags: ['auth'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(required: [
                'token', 'email', 'password', 'password_confirmation',
            ], properties: [
                new OAT\Property(property: 'token', type: 'string'),
                new OAT\Property(property: 'email', type: 'string', format: 'email'),
                new OAT\Property(property: 'password', type: 'string', format: 'password'),
                new OAT\Property(property: 'password_confirmation', type: 'string', format: 'password'),
            ]),
        ),
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_OK,
                description: 'Password updated',
                content: new OAT\JsonContent(required: ['status'], properties: [
                    new OAT\Property(property: 'status', type: 'string'),
                ]),
            ),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/UnprocessableEntity'),
        ],
    )]
    public function store(Request $request): BaseResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required', 'confirmed',
                Rules\Password::min(8)->letters()->mixedCase()->numbers(),
            ],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function ($user) use ($request): void {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return new BaseResponse(['status' => __($status)]);
    }
}
