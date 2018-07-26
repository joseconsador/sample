<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the models restaurant.
     *
     * @param  \App\Models\User  $user
     * @param  Restaurant  $restaurant
     * @return mixed
     */
    public function view(User $user, Restaurant $restaurant)
    {
        if ($user->hasRole('owner')) {
            return ($user->is($restaurant->owner));
        }

        return true;
    }

    /**
     * Determine whether the user can create models restaurants.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->hasPermissionTo('create-restaurant'));
    }

    /**
     * Determine whether the user can update the models restaurant.
     *
     * @param  \App\Models\User  $user
     * @param  Restaurant  $restaurant
     * @return mixed
     */
    public function update(User $user, Restaurant $restaurant)
    {
        return ($user->hasRole('owner') && $user->is($restaurant->owner));
    }

    /**
     * Determine whether the user can delete the models restaurant.
     *
     * @param  \App\Models\User  $user
     * @param  Restaurant  $restaurant
     * @return mixed
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        //
    }
}
