<?php

namespace App\Services;

use App\Models\User;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
    public function getAvatarFromS3(User $user): StreamedResponse|BinaryFileResponse
    {
        if ($user->profile?->image === null) {
            return response()->download(public_path('images/avatar.png'));
        }

        return ImageService::getImage($user->profile->image);
    }
}
