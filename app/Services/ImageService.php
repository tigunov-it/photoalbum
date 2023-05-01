<?php

namespace App\Services;

use App\Enums\Size;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
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
        $imagePath = self::uploadFile(
            self::generatePostsDirectoryName($user, $dateTime),
            $image,
        );

        $imageSmall = Image::make($image)
            ->resize(Size::S->value, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
            ->encode('jpg', 30);

        $imagePathSmall = self::uploadFile(
            self::generatePostsSubDirectoryName($user, $dateTime, $imageSmall, Size::S),
            $imageSmall,
        );

        $imageMedium = Image::make($image)
            ->resize(Size::M->value, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
            ->encode('jpg', 50);

        $imagePathMedium = self::uploadFile(
            self::generatePostsSubDirectoryName($user, $dateTime, $imageMedium, Size::M),
            $imageMedium,
        );

        $imageLarge = Image::make($image)
            ->resize(Size::L->value, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
            ->encode('jpg', 80);

        $imagePathLarge = self::uploadFile(
            self::generatePostsSubDirectoryName($user, $dateTime, $imageLarge, Size::L),
            $imageLarge,
        );

        return [
            'image' => $imagePath,
            'image_small' => $imagePathSmall,
            'image_medium' => $imagePathMedium,
            'image_large' => $imagePathLarge,
        ];
    }

    public static function generatePostsDirectoryName(User $user, Carbon $dateTime): string
    {
        return sprintf(
            'uploads/%s/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
        );
    }

    public static function generatePostsSubDirectoryName(User $user, Carbon $dateTime, File $file, Size $size): string
    {
        return sprintf(
            'uploads/%s/%s/%s/%s',
            $user->username,
            $dateTime->format('Y-m-d_H:i:s'),
            match ($size) {
                Size::S => 'small',
                Size::M => 'medium',
                Size::L => 'large',
                default => '',
            },
            $file->basename,
        );;
    }

    public static function uploadFile(string $path, StreamInterface|File|UploadedFile|string $file): string
    {
        Storage::disk('s3')->put($path, $file);

        return $path;
    }

    /**
     * @throws NotFoundHttpException
     */
    public static function getImage(string $path): Response
    {
        $file = Storage::disk('s3cache')->get($path);
        if ($file === null) {
            $file = Storage::disk('s3')->get($path);
            if ($file === null) {
                throw new NotFoundHttpException(__('http-statuses.404'));
            }

            Storage::disk('s3cache')->put($path, $file);
        }

        return response($file)->header('Content-Type', Storage::disk('s3cache')->mimeType($path));
    }

    public static function delete(string $path): bool
    {
        return Storage::disk('s3')->delete($path);
    }

    public static function deleteFolder(string $folder): bool
    {
        return Storage::disk('s3')->deleteDirectory($folder);
    }

    public static function downloadZip(Carbon $dateTime): StreamedResponse
    {
        $user = Auth::user();

        $directory = self::generatePostsDirectoryName($user, $dateTime);

        $fileNames = Storage::disk('s3')->files($directory);

        $zipFile = Storage::disk('s3cache')->path("$directory/album.zip");
        $zip = new \ZipArchive();

        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($fileNames as $fileName) {

            $fileContent = Storage::disk('s3')->get($fileName);
            $imageName = substr(strrchr($fileName, '/'), 1);
            Storage::disk('s3cache')->put("$directory/$imageName", $fileContent);

            $path = Storage::disk('s3cache')->path("$directory/$imageName");
            $zip->addFile($path, $imageName);
        }

        $zip->close();

        return Storage::disk('s3cache')->download("$directory/album.zip");
    }
}
