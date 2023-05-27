<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class HandleCors extends \Illuminate\Http\Middleware\HandleCors
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if (!$this->hasMatchingPath($request)) {
            return $next($request);
        }

        $this->cors->setOptions($this->container['config']->get('cors', []));

        if ($this->cors->isPreflightRequest($request)) {
            $response = $this->cors->handlePreflightRequest($request);

            $this->cors->varyHeader($response, 'Access-Control-Request-Method');

            Log::debug(
                'preflight header',
                ['access-control-allow-origin' => $response->headers->all('access-control-allow-origin')],
            );

            return $response;
        }

        $response = $next($request);

        if ($request->getMethod() === 'OPTIONS') {
            $this->cors->varyHeader($response, 'Access-Control-Request-Method');
        }

        $response = $this->cors->addActualRequestHeaders($response, $request);

        Log::debug(
            'header',
            ['access-control-allow-origin' => $response->headers->all('access-control-allow-origin')],
        );

        return $response;
    }
}
