<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $user = Auth::user();

        return view('posts.create', [
            'user' => $user
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'album' => 'required',
            'image' => ['required', 'image']
        ]);

        $imagePath = request('image')->store('uploads', 'public');

//        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1024, 768);
        $image = Image::make(public_path("storage/{$imagePath}"))->encode('jpg', 30);
        $image->save();

        auth()->user()->posts()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'album_id' => $data['album'],
            'image' => $imagePath
        ]);
        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
}
