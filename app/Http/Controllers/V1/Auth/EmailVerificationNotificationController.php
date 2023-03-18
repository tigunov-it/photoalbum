<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

final class EmailVerificationNotificationController extends Controller
{
    #[OAT\Post(
        path: '/api/v1/email/verification-notification',
        description: 'Send a new email verification notification',
        tags: ['auth'],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_OK,
                description: 'Email verification notification sent',
                content: new OAT\JsonContent(required: ['status'], properties: [
                    new OAT\Property(property: 'status', type: 'string'),
                ]),
            ),
        ],
    )]
    public function store(Request $request): BaseResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return new BaseResponse(['status' => 'verification-link-sent']);
    }
}
