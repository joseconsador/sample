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
    Route::group(['prefix' => 'restaurants', 'as' => 'restaurant::'], function () {
        Route::get('/', ['uses' => 'API\RestaurantsController@index']);
        Route::get('/{restaurant}', ['as' => 'show', 'uses' => 'API\RestaurantsController@show']);
        Route::post('/', [
           'uses' => 'API\RestaurantsController@store',
           'middleware' => ['permission:create-restaurant']
        ]);
        Route::put('/{restaurant}', ['uses' => 'API\RestaurantsController@update']);
    });
});
