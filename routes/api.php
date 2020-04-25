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



Route::post('auth/login', 'Api\AuthController@login')->name('login');
Route::post('auth/signup', 'Api\AuthController@signup');

Route::group([
  'middleware' => 'auth:api'
], function() {
    Route::delete('auth/logout', 'Api\AuthController@logout');
    Route::get('auth/me', 'Api\AuthController@user');

    Route::post('storage', 'Api\StorageController@upload');
    Route::post('blog/categories', 'Api\CategoryController@store');
});
