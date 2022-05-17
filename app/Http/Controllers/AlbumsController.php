<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AlbumsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {

        $this->authorize('update', $user->profile);

        return view('albums.index', [
            'user' => $user
        ]);
    }

    public function show(User $user, Album $album)
    {

        $this->authorize('update', $user->profile);

        $posts = \DB::table('posts')->where('album_id', '=', $album->id)
            ->where('user_id', '=', $user->id)->paginate(20);

        return view('albums.show', [
            'posts' => $posts,
            'user' => $user,
            'album' => $album
        ]);
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => ['required', 'image']
        ]);

        $album = auth()->user()->album()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => ''
        ]);

        $user = Auth::user();
        $albumForUpload = \DB::select("select created_at from albums where id = {$album->id}");
        $albumCreatedAt = str_replace(" ", "_", implode(" ", array_column($albumForUpload, 'created_at')));

        ############################# Делаем обложку альбома малого размера
        $imagePathSmallLocal = request('image')->store("uploads/{$user->username}/{$albumCreatedAt}/cover/", 'public');
        $image = Image::make(public_path("storage/{$imagePathSmallLocal}"))->fit(252, 252)->encode('jpg', 50);
        Storage::disk('s3')->put("uploads/{$user->username}/{$albumCreatedAt}/cover/{$image->basename}", $image);
        unlink("storage/{$imagePathSmallLocal}"); // Удаляю локальный файл после обработки и загрузки в S3

        $album->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $imagePathSmallLocal
        ]);

        return redirect('/a/' . auth()->user()->id);

    }

    public function getCoverFromS3(User $user, Album $album)

    {
        $this->authorize('update', $user->profile);

        return Storage::disk('s3')->response("{$album->image}");

    }

}
