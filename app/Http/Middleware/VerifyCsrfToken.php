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
        $isReading = $this->isReading($request);
        $runningUnitTests = $this->runningUnitTests();
        $inExceptArray = $this->inExceptArray($request);
        $tokensMatch = $this->tokensMatch($request);
        $shouldAddXsrfTokenCookie = $this->shouldAddXsrfTokenCookie();

        \Illuminate\Support\Facades\Log::channel('telegram')->debug(
            $request->fullUrl(),
            compact('isReading', 'runningUnitTests', 'inExceptArray', 'tokensMatch', 'shouldAddXsrfTokenCookie'),
        );

        if (
            $isReading ||
            $runningUnitTests ||
            $inExceptArray ||
            $tokensMatch
        ) {
            return tap($next($request), function ($response) use ($request) {
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
