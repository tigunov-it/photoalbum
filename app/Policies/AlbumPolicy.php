<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

final class AlbumPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Album $album): Response|bool
    {
        return $user->id === $album->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Album $album): Response|bool
    {
        return $user->id === $album->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Album $album): Response|bool
    {
        return $user->id === $album->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Album $album): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Album $album): Response|bool
    {
        return false;
    }
}
