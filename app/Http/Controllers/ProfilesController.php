<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfilesController extends Controller
{
    public function index(User $user)
    {

        $this->authorize('update', $user->profile);

        $posts = $user->posts()->paginate(20);

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
    public function update(User $user, ProfileService $service)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        $service->update($user, $data);

        return redirect("/profile/{$user->id}");
    }

    public function getAvatarFromS3(User $user, ProfileService $service): StreamedResponse
    {
        $this->authorize('update', $user->profile);

        return $service->getAvatarFromS3($user);
    }

}
