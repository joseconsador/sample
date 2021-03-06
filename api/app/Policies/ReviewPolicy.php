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
     * @param Review $review
     * @return mixed
     */
    public function update(User $user, Review $review)
    {
        return ($user->hasPermissionTo('review-restaurant') && $user->is($review->user));
    }

    /**
     * Determine whether the user can reply to the review.
     *
     * @param  \App\Models\User $user
     * @param Review $review
     * @return mixed
     */
    public function reply(User $user, Review $review)
    {
        return ($user->hasPermissionTo('create-restaurant') && $user->is($review->restaurant->owner));
    }
}
