<?php

namespace App\Services;

use App\Http\Responses\ImageResponse;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ProfileService
{
    public function update(User $user, $data): bool
    {
        $profile = $user->profile;

        if (array_key_exists('image', $data)) {

            if ($profile->image !== null) {
                ImageService::delete($profile->image);
            }

            if (!empty($data['image'])) {
                $data['image'] = ImageService::uploadProfileImage($user, $data['image']);
            }
        }

        return $profile->update($data);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getAvatarFromS3(User $user): ImageResponse
    {
        if ($user->profile?->image === null) {
            $path = public_path('images/avatar.png');

            return new ImageResponse(
                File::get($path),
                File::mimeType($path),
            );
        }

        return new ImageResponse(
            ImageService::getImage($user->profile->image),
            ImageService::getImageType($user->profile->image),
        );
    }
}
