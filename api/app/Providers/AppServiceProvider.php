<?php

namespace App\Providers;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use App\Observers\RestaurantObserver;
use App\Observers\ReviewObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Review::observe(ReviewObserver::class);
        Restaurant::observe(RestaurantObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
