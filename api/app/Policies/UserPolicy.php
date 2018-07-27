<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the models user.
     *
     * @param User $currentUser
     * @param User $user
     * @return boolean
     */
    public function view(User $currentUser, User $user)
    {
        return $currentUser->is($user);
    }

    /**
     * Determine whether the user can update the models user.
     *
     * @param User $currentUser
     * @param User $user
     * @return boolean
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->is($user);
    }
}
