<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the models review.
     *
     * @param  \App\Models\User $user
     * @param \App\Policies\Review $Review
     * @return mixed
     */
    public function view(User $user, Review $Review)
    {
        //
    }

    /**
     * Determine whether the user can create models reviews.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('review-restaurant');
    }

    /**
     * Determine whether the user can update the models review.
     *
     * @param  \App\Models\User $user
     * @param Review $Review
     * @return mixed
     */
    public function update(User $user, Review $Review)
    {
        //
    }

    /**
     * Determine whether the user can delete the models review.
     *
     * @param  \App\Models\User $user
     * @param Review $Review
     * @return mixed
     */
    public function delete(User $user, Review $Review)
    {
        //
    }
}
