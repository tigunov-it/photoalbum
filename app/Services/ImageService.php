<?php

namespace App\Services;

use App\Enums\Size;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use Intervention\Image\File;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    /**
     * @return array{image: string, image_small: string, image_medium: string, image_large: string}
     */
    public static function uploadPostImage(User $user, UploadedFile $image, Carbon $dateTime): array
    {
        $imagePath = self::uploadFile(sprintf(
            'uploads/%s/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
        ), $image);

        $imageSmall = Image::make($image)
            ->resize(Size::S->value, null, static fn (Constraint $constraint): void => $constraint->aspectRatio())
            ->encode('jpg', 30);

        $imagePathSmall = self::uploadFile(sprintf(
            'uploads/%s/%s/small/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
            $imageSmall->basename,
        ), $imageSmall);

        $imageMedium = Image::make($image)
            ->resize(Size::M->value, null, static fn (Constraint $constraint): void => $constraint->aspectRatio())
            ->encode('jpg', 50);

        $imagePathMedium = self::uploadFile(sprintf(
            'uploads/%s/%s/medium/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
            $imageMedium->basename,
        ), $imageMedium);

        $imageLarge = Image::make($image)
            ->resize(Size::L->value, null, static fn (Constraint $constraint): void => $constraint->aspectRatio())
            ->encode('jpg', 80);

        $imagePathLarge = self::uploadFile(sprintf(
            'uploads/%s/%s/large/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
            $imageLarge->basename,
        ), $imageLarge);

        return [
            'image' => $imagePath,
            'image_small' => $imagePathSmall,
            'image_medium' => $imagePathMedium,
            'image_large' => $imagePathLarge,
        ];
    }

    public static function uploadFile(string $path, StreamInterface|File|UploadedFile|string $file): string
    {
        Storage::disk('s3')->put($path, $file);

        return $path;
    }

    /**
     * @throws NotFoundHttpException
     */
    public static function getImage(string $path): StreamedResponse
    {
        if (!Storage::disk('s3')->fileExists($path)) {
            throw new NotFoundHttpException(__('http-statuses.404'));
        }

        return Storage::disk('s3')->response($path);
    }

    public static function delete(string $path): bool
    {
        return Storage::disk('s3')->delete($path);
    }

    public static function deleteFolder(string $folder): bool
    {
        return Storage::disk('s3')->deleteDirectory($folder);
    }
}
