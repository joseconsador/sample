<?php

namespace App\Providers;

use App\Utility\ApiClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class ApiClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiClient::class, function ($app) {
            $guzzle = new Client([
                'base_uri' => config('services.restaurant.url'),
            ]);

            return new ApiClient($guzzle);
        });
    }
}
