<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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
                $imagePath = $data['image']->store("uploads/{$user->username}/profile", 'public');
                $image = Image::make(public_path("storage/{$imagePath}"))->fit(100, 100)->encode('jpg', 30);
                Storage::disk('s3')->put("uploads/{$user->username}/profile/{$image->basename}", $image);
                unlink("storage/{$imagePath}"); // Удаляю локальный файл после обработки и загрузки в S3

                $data['image'] = $imagePath;
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
