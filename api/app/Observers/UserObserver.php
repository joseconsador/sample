<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Delete all reviews for the restaurant
     *
     * @param User $user
     */
    public function deleting(User $user) {
        foreach ($user->restaurants()->getResults() as $restaurant) {
            $restaurant->delete();
        }

        $user->reviews()->delete();
    }
}