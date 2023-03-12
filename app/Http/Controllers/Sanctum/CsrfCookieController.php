<?php

namespace App\Http\Controllers\Sanctum;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController as BaseCsrfCookieController;
use OpenApi\Attributes as OAT;

class CsrfCookieController extends BaseCsrfCookieController
{
    #[OAT\Get(
        path: '/api/sanctum/csrf-cookie',
        description: 'Return an empty response simply to trigger the storage of the CSRF/XSRF cookie in the browser',
        tags: ['sanctum'],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_NO_CONTENT,
                description: 'Empty response simply to trigger the storage of the CSRF/XSRF cookie in the browser',
                content: new OAT\JsonContent(),
            ),
        ],
    )]
    public function show(Request $request)
    {
        return parent::show($request);
    }
}
