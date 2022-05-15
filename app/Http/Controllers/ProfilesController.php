<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {

        $this->authorize('update', $user->profile);

        $posts = $user->posts()->paginate(6);

        return view('profiles.index', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {

        $this->authorize('update', $user->profile);

        return view('profiles.edit', [
            'user' => $user
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if (request('image')) {
            $imagePath = request('image')->store("uploads/{$user->username}/profile", 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(100, 100)->encode('jpg', 30);
            Storage::disk('s3')->put("uploads/{$user->username}/profile/{$image->basename}", $image);
            unlink("storage/{$imagePath}"); // Удаляю локальный файл после обработки и загрузки в S3


            $imageArray = ['image' => $imagePath];
        }

        $user->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));


//        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }

    public function getAvatarFromS3(User $user)

    {
        $this->authorize('update', $user->profile);

        return Storage::disk('s3')->response("{$user->profile->image}");

    }

}
