<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, \Closure $next)
    {
        \Illuminate\Support\Facades\Log::channel('telegram')->debug($request->fullUrl());

        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            return tap($next($request), function ($response) use ($request) {
                \Illuminate\Support\Facades\Log::channel('telegram')->debug((string) $this->shouldAddXsrfTokenCookie());
                if ($this->shouldAddXsrfTokenCookie()) {
                    \Illuminate\Support\Facades\Log::channel('telegram')->debug(
                        $this->newCookie($request, config('session')),
                    );
                    $this->addCookieToResponse($request, $response);
                }
            });
        }

        throw new \Illuminate\Session\TokenMismatchException('CSRF token mismatch.');
    }
}
