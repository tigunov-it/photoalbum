<?php

namespace App\Http\Controllers;

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
        return view('albums.index', [
            'user' => $user
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
