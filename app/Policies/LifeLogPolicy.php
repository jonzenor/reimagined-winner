<?php

namespace App\Policies;

use App\Models\LifeLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LifeLogPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role != null && $user->role->name == 'Super Admin') {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->role != null && $user->role->name == 'Admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LifeLog $lifeLog): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role != null && $user->role->name == 'Admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LifeLog $lifeLog): bool
    {
        if ($user->role != null && $user->role->name == 'Admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LifeLog $lifeLog): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LifeLog $lifeLog): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LifeLog $lifeLog): bool
    {
        //
    }
}
