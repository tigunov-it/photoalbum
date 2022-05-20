<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function rotate(Post $post)
    {

        return 'rotate';
    }

    public function download(User $user, Post $post)
    {

        $this->authorize('update', $user->profile);

        $filename = substr(strrchr($post->image, '/'), 1);

        $headers = [
            'Content-Type' => 'application/jpeg',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return \Response::make(Storage::disk('s3')->get($post->image), 200, $headers);
    }


    public function downloadZip(User $user, Album $album)
    {

        $album = \DB::select("select created_at from albums where id = {$album->id}");
        $albumCreatedAt = str_replace(" ", "_", implode(" ", array_column($album, 'created_at')));
        $directory = "uploads/{$user->username}/{$albumCreatedAt}/";

        $file_names = Storage::disk('s3')->files($directory);

        $zip_file = 'storage/forzip/album.zip';
        $zip = new \ZipArchive();

        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($file_names as $file_name) {

            $file_content = Storage::disk('s3')->get($file_name);
            $imagename = substr(strrchr($file_name, '/'), 1);
            $s3 = Storage::disk('public');
            $s3->put("/forzip/$imagename", $file_content);


            $invoice_file = "storage/forzip/$imagename";
            $zip->addFile(public_path($invoice_file), $imagename);

        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="album.zip"',
        ];

        return \Response::make(Storage::disk('public')->get('forzip/album.zip'), 200, $headers);

    }

}
