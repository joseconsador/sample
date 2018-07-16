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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ['auth.basic.once'], 'as' => 'api::'], function () {
    // api/restaurants routes
    Route::group(['prefix' => 'restaurants', 'as' => 'restaurant::'], function () {
        Route::get('/', ['uses' => 'API\RestaurantsController@index']);
        Route::post('/', [
            'uses' => 'API\RestaurantsController@store',
            'middleware' => ['permission:create-restaurant']
        ]);
        Route::put('/{restaurant}', ['uses' => 'API\RestaurantsController@update']);

        // api/restaurants/<ID>/reviews routes
        Route::group(['prefix' => '/{restaurant}', 'as' => 'show'], function () {
            Route::get('/', ['uses' => 'API\RestaurantsController@show']);

            Route::group(['prefix' => 'reviews', 'as' => '::reviews'], function () {
                Route::get('/', ['uses' => 'API\ReviewsController@index']);
            });
        });
    });
});
