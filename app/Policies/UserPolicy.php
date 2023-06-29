<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_role_id > 1; // Only moderators/administrators
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, string $id): bool
    {
        $model = User::find($id);

        if ($user->user_role_id > 1) // Moderator/Administrator
        {
            return true;
        }

        if ($user->id === $model->id)
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, string $id): bool
    {
        $model = User::find($id);

        if ($user->user_role_id > $model->user_role_id) // Higher rank
        {
            return true;
        }

        if ($user->id === $model->id)
        {
            return true;
        }

        return false;
    }

    /**
    * Determine whether the user can update the user_role_id of the model.
    */
    public function updateUserRole(User $user): bool
    {
        return $user->user_role_id === 3; // Only administrators
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->user_role_id === 3; // Only administrators
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->user_role_id === 3; // Only administrators
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->user_role_id === 3; // Only administrators
    }
}
