<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use OpenApi\Attributes as OAT;

final class VerifyEmailController extends Controller
{
    #[OAT\Get(
        path: '/api/verify-email/{id}/{hash}',
        description: 'Mark the authenticated user\'s email address as verified',
        tags: ['auth'],
        parameters: [
            new OAT\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'integer', format: 'int64', minimum: 1),
            ),
            new OAT\Parameter(
                name: 'hash',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string'),
            ),
        ],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_FOUND,
                description: 'Email verified',
                content: new OAT\JsonContent(),
            ),
            new OAT\Response(
                response: JsonResponse::HTTP_FORBIDDEN,
                description: 'Forbidden',
                content: new OAT\JsonContent(),
            ),
        ],
    )]
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(
            config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
        );
    }
}
