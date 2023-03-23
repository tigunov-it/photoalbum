<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\File;

final class ImageService
{
    public static function uploadProfileImage(User $user, UploadedFile $image): string
    {
        $image = Image::make($image)->fit(100, 100)->encode('jpg', 30);

        $path = sprintf(
            'uploads/%s/profile/%s',
            $user->username,
            $image->basename,
        );

        return self::uploadFile($path, $image);
    }

    public static function uploadAlbumImage(User $user, UploadedFile $image, Carbon $dateTime): string
    {
        $image = Image::make($image)->fit(252, 252)->encode('jpg', 50);

        $path = sprintf(
            'uploads/%s/%s/cover/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
            $image->basename,
        );

        return self::uploadFile($path, $image);
    }

    public static function uploadFile(string $path, File $image): string
    {
        Storage::disk('s3')->put($path, $image);

        return $path;
    }
}
