<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/users', ['as' => 'create', 'uses' => 'API\UsersController@store']);

Route::group(['middleware' => ['auth:api'], 'as' => 'api::'], function () {
    // api/user routes
    Route::group(['prefix' => 'users', 'as' => 'users::'], function () {
        Route::get('/{user}', ['as' => 'show', 'uses' => 'API\UsersController@show']);
        Route::get('/{user}/reviews', ['uses' => 'API\UsersController@reviews']);
    });

    // api/restaurants routes
    Route::group(['prefix' => 'restaurants', 'as' => 'restaurant::'], function () {
        Route::get('/', ['uses' => 'API\RestaurantsController@index']);
        Route::post('/', [
            'uses' => 'API\RestaurantsController@store',
            'middleware' => ['permission:create-restaurant'],
        ]);
        Route::put('/{restaurant}', ['uses' => 'API\RestaurantsController@update'])->where('restaurant', '[0-9]+');
        Route::delete('/{restaurant}', ['uses' => 'API\RestaurantsController@destroy'])->where('restaurant', '[0-9]+');

        // api/restaurants/<ID>/reviews routes
        Route::group(['prefix' => '/{restaurant}', 'as' => 'show'], function () {
            Route::get('/', ['uses' => 'API\RestaurantsController@show']);
            Route::get('/review', ['uses' => 'API\ReviewsController@fromUser'])->where('restaurant', '[0-9]+');

            Route::group(['prefix' => 'reviews', 'as' => '::reviews'], function () {
                Route::get('/', ['uses' => 'API\ReviewsController@index']);
                Route::get('/highlights', ['uses' => 'API\ReviewsController@highlights']);
                Route::get('/pending', ['uses' => 'API\ReviewsController@pending']);

                Route::get('/{review}', ['as' => '::show', 'uses' => 'API\ReviewsController@show'])
                    ->where('review', '[0-9]+');

                Route::match(['post', 'put'], '/{review}/reply', ['uses' => 'API\ReviewsController@reply'])
                    ->where('review', '[0-9]+');

                Route::group(['middleware' => ['permission:review-restaurant']], function () {
                    Route::post('/', ['uses' => 'API\ReviewsController@store']);

                    Route::put('/{review}', ['uses' => 'API\ReviewsController@update'])->where('review', '[0-9]+');
                    Route::delete('/{review}', ['uses' => 'API\ReviewsController@destroy'])->where('review', '[0-9]+');
                });
            });
        });
    });
});
