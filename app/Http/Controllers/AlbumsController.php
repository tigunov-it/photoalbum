<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        //TODO: Сделать оптимальное решение для приватности фотоальбомов
        $this->authorize('update', $user->profile);


        $posts = \DB::table('posts')->where('album_id', '=', $album->id)
            ->where('user_id', '=', $user->id)->paginate(3);

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

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1024, 768);
//        $image = Image::make(public_path("storage/{$imagePath}"))->encode('jpg', 30);
        $image->save();

        auth()->user()->album()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $imagePath
        ]);
        return redirect('/profile/' . auth()->user()->id);
    }

}
