<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

final class ProfileService
{
    /**
     * TODO: Refactor
     */
    public function update(User $user, $data): bool
    {
        if ($data['image']) {
            $imagePath = request('image')->store("uploads/{$user->username}/profile", 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(100, 100)->encode('jpg', 30);
            Storage::disk('s3')->put("uploads/{$user->username}/profile/{$image->basename}", $image);
            unlink("storage/{$imagePath}"); // Удаляю локальный файл после обработки и загрузки в S3

            $imageArray = ['image' => $imagePath];
        }

        return $user->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));
    }

    /**
     * TODO: Refactor
     */
    public function getAvatarFromS3(User $user): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Storage::disk('s3')->response("{$user->profile->image}");
    }
}
