<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Post;
use Aws\AwsClient;
use Aws\Rekognition\RekognitionClient;
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
            'image' => 'required',
            'image.*' => 'image'
        ]);


        $client = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest'
        ]);

        foreach (request('image') as $file) {

            $imageForAnalise = fopen($file, 'r');
            $bytes = fread($imageForAnalise, filesize($file));
            $results = $client->detectModerationLabels([
                'Image' => ['Bytes' => $bytes],
                'MinConfidence' => 50
            ]);
            $resultLabels = $results->get('ModerationLabels');

            $banned = implode(", ",array_column($resultLabels, 'Name'));

            if(!empty($resultLabels)){
                return redirect()->back()->withErrors(['Banned_content' => 'The image contained Prohibited Content ' . '(' . $banned . ')']);
            };

            $user = Auth::user();
            $album = \DB::select("select created_at from albums where id = {$data['album']}");
            $albumCreatedAt = str_replace(" ", "_", implode(" ", array_column($album, 'created_at')));

            $imagePath = $file->store("uploads/{$user->username}/{$albumCreatedAt}/", 'public');
//            $image = Image::make(public_path("storage/{$imagePath}"))->encode('jpg', 30);
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1024, 768)->encode('jpg', 30);
            $image->save();

            auth()->user()->posts()->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'album_id' => $data['album'],
                'image' => $imagePath
            ]);

        }

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
