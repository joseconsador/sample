<?php

namespace App\Providers;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use App\Policies\RestaurantPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Restaurant::class => RestaurantPolicy::class,
        Review::class => ReviewPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(function ($router) {
            $router->forAccessTokens();
            $router->forPersonalAccessTokens();
            $router->forTransientTokens();
        });

        Passport::tokensExpireIn(Carbon::now()->addMinutes(config('auth.token.expiry')));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
    }
}
