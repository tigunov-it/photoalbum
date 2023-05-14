<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\ImageResponse;
use App\Http\Responses\UnsuccessfulResponse;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OAT;

final class ProfileController extends Controller
{
    #[OAT\Get(
        path: '/api/v1/profile',
        summary: 'Display profile',
        tags: ['profile'],
        responses: [new OAT\Response(
            response: JsonResponse::HTTP_OK,
            description: 'Profile',
            content: new OAT\JsonContent(ref: '#/components/schemas/Profile'),
        )],
    )]
    public function show(Request $request): BaseResponse
    {
        return new BaseResponse($request->user()->profile);
    }

    #[OAT\Get(
        path: '/api/v1/profile/s3avatar',
        summary: 'Display avatar',
        tags: ['profile'],
        responses: [new OAT\Response(response: JsonResponse::HTTP_OK, ref: '#/components/responses/ImageResponse')],
    )]
    public function getAvatarFromS3(Request $request, ProfileService $service): ImageResponse
    {
        return $service->getAvatarFromS3($request->user());
    }

    #[OAT\Post(
        path: '/api/v1/profile',
        summary: 'Update profile',
        requestBody: new OAT\RequestBody(ref: '#/components/requestBodies/ProfileUpdateRequest'),
        tags: ['profile'],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_NO_CONTENT,
                description: 'Profile updated',
                content: new OAT\JsonContent(),
            ),
            new OAT\Response(response: JsonResponse::HTTP_BAD_REQUEST, ref: '#/components/responses/UnsuccessfulResponse'),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/UnprocessableEntity'),
        ],
    )]
    public function update(ProfileUpdateRequest $request, ProfileService $service): BaseResponse
    {
        if ($service->update($request->user(), $request->validated())) {
            return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
        }

        return new UnsuccessfulResponse;
    }

    #[OAT\Delete(
        path: '/api/v1/profile',
        summary: 'Deactivate profile',
        requestBody: new OAT\RequestBody(content: new OAT\JsonContent(required: ['password'], properties: [
            new OAT\Property(property: 'password', type: 'string', format: 'password'),
        ])),
        tags: ['profile'],
        responses: [
            new OAT\Response(
                response: JsonResponse::HTTP_NO_CONTENT,
                description: 'Deactivation successful',
                content: new OAT\JsonContent(),
            ),
            new OAT\Response(response: JsonResponse::HTTP_BAD_REQUEST, ref: '#/components/responses/UnsuccessfulResponse'),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/UnprocessableEntity'),
        ],
    )]
    public function destroy(Request $request): BaseResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        /** @var \App\Models\User */
        $user = $request->user();

        Auth::guard('web')->logout();

        $profileDeleted = $user->profile->delete();
        $userDeleted = $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($profileDeleted && $userDeleted) {
            return new BaseResponse(status: JsonResponse::HTTP_NO_CONTENT);
        }

        return new UnsuccessfulResponse;
    }
}
