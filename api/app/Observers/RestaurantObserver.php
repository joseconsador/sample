<?php

namespace App\Observers;

use App\Models\Restaurant;

class RestaurantObserver
{
    /**
     * Delete all reviews for the restaurant
     *
     * @param Restaurant $restaurant
     */
    public function deleting(Restaurant $restaurant) {
        $restaurant->reviews()->delete();
    }
}