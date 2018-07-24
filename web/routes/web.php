<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/login', 'Auth\LoginController@login');
Route::delete('/logout', 'Auth\LoginController@logout');
Route::get('/api/{any}', 'SpaController@proxy')->where('any', '.*');
Route::get('/{any}', 'SpaController@index')->where('any', '.*');