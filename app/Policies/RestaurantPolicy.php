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
        if ($user->hasRole('admmin')) {
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
        //
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
        $fkeyVal = $user->getAttribute($restaurant->owner()->getOwnerKey());
        $lkeyVal = $restaurant->getAttribute($restaurant->owner()->getForeignKey());

        return ($user->hasRole('owner') && $fkeyVal == $lkeyVal);
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
