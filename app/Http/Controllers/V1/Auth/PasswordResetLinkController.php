<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OAT;

final class PasswordResetLinkController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OAT\Post(
        path: '/api/v1/forgot-password',
        description: 'Send password reset link request',
        tags: ['auth'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(required: ['email'], properties: [
                new OAT\Property(property: 'email', type: 'string', format: 'email'),
            ]),
        ),
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_OK,
                description: 'Password reset link sent',
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
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return new BaseResponse(['status' => __($status)]);
    }
}
