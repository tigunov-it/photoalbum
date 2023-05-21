<?php

namespace App\Services;

use App\Enums\Size;
use App\Http\Responses\ImageResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as ImageFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ImageService
{
    public static function uploadProfileImage(User $user, UploadedFile $image): string
    {
        $fileName = $image->hashName();
        $image = Image::make($image)->fit(100, 100)->encode('jpg', 30);
        $path = self::generateProfileDirectoryName($user);

        return self::uploadFile($path, $image, $fileName);
    }

    public static function generateProfileDirectoryName(User $user): string
    {
        return sprintf('uploads/%s/profile', $user->username);
    }

    public static function uploadAlbumImage(User $user, UploadedFile $image, Carbon $dateTime): string
    {
        $fileName = $image->hashName();
        $image = Image::make($image)->fit(252, 252)->encode('jpg', 50);
        $path = self::generateAlbumDirectoryName($user, $dateTime);

        return self::uploadFile($path, $image, $fileName);
    }

    public static function generateAlbumDirectoryName(User $user, Carbon $dateTime): string
    {
        return sprintf('uploads/%s/%s/cover', $user->username, $dateTime->format('Y-m-d_H:i:s'));
    }

    /**
     * @return array{image: string, image_small: string, image_medium: string, image_large: string, exif: array}
     */
    public static function uploadPostImage(User $user, ImageFile|UploadedFile $image, Carbon $dateTime): array
    {
        $fileName = $image instanceof UploadedFile ? $image->hashName() : $image->basename;
        $path = self::generatePostsDirectoryName($user, $dateTime);

        return self::uploadPostImageToPath($path, $image, $fileName);
    }

    public static function generatePostsDirectoryName(User $user, Carbon $dateTime): string
    {
        return sprintf('uploads/%s/%s', $user->username, $dateTime->format('Y-m-d_H:i:s'));
    }

    /**
     * @return array{image: string, image_small: string, image_medium: string, image_large: string, exif: array}
     */
    public static function uploadPostImageToPath(string $path, ImageFile|UploadedFile $image, string $fileName): array
    {
        $imagePath = self::uploadFile($path, $image, $fileName);
        $image = Image::make($image);

        return [
            'image' => $imagePath,
            'image_small' => self::resizeAndUploadPostImage($path, $image, $fileName, Size::S),
            'image_medium' => self::resizeAndUploadPostImage($path, $image, $fileName, Size::M),
            'image_large' => self::resizeAndUploadPostImage($path, $image, $fileName, Size::L),
            'exif' => $image->exif(),
        ];
    }

    public static function resizeAndUploadPostImage(string $path, ImageFile $image, string $fileName, Size $size): string
    {
        $image = self::resizeImage($image, $size);
        $path = self::generatePostsSubDirectoryName($path, $size);

        return self::uploadFile($path, $image, $fileName);
    }

    public static function resizeImage(ImageFile $image, Size $size): ImageFile
    {
        return match ($size) {
            Size::S => $image
                ->resize(Size::S->value, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
                ->encode('jpg', 30),
            Size::M => $image
                ->resize(Size::M->value, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
                ->encode('jpg', 50),
            Size::L => $image
                ->resize(Size::L->value, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
                ->encode('jpg', 80),
            default => $image,
        };
    }

    public static function getReducedImage(UploadedFile $image, int $maxFileSize): bool|string
    {
        $fileSize = $image->getSize();

        if ($fileSize > $maxFileSize) {
            ini_set('memory_limit', '-1');

            $image = Image::make($image);

            while ($fileSize > $maxFileSize) {
                $reducedWidth = (int) round($image->getWidth() / 2);
                $image->resize($reducedWidth, null, static fn (Constraint $constraint) => $constraint->aspectRatio())
                    ->encode('jpg');
                $fileSize = mb_strlen($image->getEncoded(), '8bit');
            }

            return $image->getEncoded();
        }

        return $image->get();
    }

    public static function generatePostsSubDirectoryName(string $path, Size $size): string
    {
        return sprintf('%s/%s', $path, $size->title());
    }

    public static function uploadFile(string $path, ImageFile|UploadedFile $file, ?string $fileName = null): string
    {
        if ($file instanceof UploadedFile) {
            $fileName ??= $file->hashName();
            $result = Storage::disk('s3')->putFileAs($path, $file, $fileName);
        } else {
            $fileName ??= $file->basename;
            $path = sprintf('%s/%s', $path, $fileName);
            $result = Storage::disk('s3')->put($path, $file);
        }

        return is_string($result) ? $result : $path;
    }

    /**
     * @throws NotFoundHttpException
     */
    public static function getImage(string $path): string
    {
        $file = Storage::disk('s3cache')->get($path);
        if ($file === null) {
            $file = Storage::disk('s3')->get($path);
            if ($file === null) {
                throw new NotFoundHttpException(__('http-statuses.404'));
            }

            Storage::disk('s3cache')->put($path, $file);
        }

        return $file;
    }

    public static function getImageType(string $path): string|false
    {
        return Storage::disk('s3cache')->mimeType($path) ?: Storage::disk('s3')->mimeType($path);
    }

    /**
     * @throws NotFoundHttpException
     */
    public static function getImageResponse(string $path): ImageResponse
    {
        return new ImageResponse(
            self::getImage($path),
            self::getImageType($path),
        );
    }

    public static function delete(string $path): bool
    {
        self::deleteCache($path);
        return Storage::disk('s3')->delete($path);
    }

    public static function deleteCache(string $path): bool
    {
        return Storage::disk('s3cache')->delete($path);
    }

    public static function deleteFolder(string $folder): bool
    {
        self::deleteCacheFolder($folder);
        return Storage::disk('s3')->deleteDirectory($folder);
    }

    public static function deleteCacheFolder(string $folder): bool
    {
        return Storage::disk('s3cache')->deleteDirectory($folder);
    }

    public static function downloadZip(Carbon $dateTime): StreamedResponse
    {
        /** @var User */
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

    /**
     * @return array{image: string, image_small: string, image_medium: string, image_large: string, exif: array}
     */
    public static function rotateImage(string $path, float $angle, string $bgcolor): array
    {
        $image = self::getImage($path);
        $image = Image::make($image)->rotate($angle, $bgcolor)->encode(quality: 100);

        return self::uploadPostImageToPath(dirname($path), $image, basename($path));
    }
}
