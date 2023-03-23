<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ProfileService
{
    public function update(User $user, $data): bool
    {
        $profile = $user->profile;

        if (array_key_exists('image', $data)) {

            if ($profile->image !== null) {
                Storage::disk('s3')->delete($profile->image);
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
    public function getAvatarFromS3(User $user): StreamedResponse
    {
        if ($user->profile?->image === null) {
            throw new NotFoundHttpException(__('http-statuses.404'));
        }

        return Storage::disk('s3')->response("{$user->profile->image}");
    }
}