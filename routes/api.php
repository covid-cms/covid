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

    Route::get('blog/categories', 'Api\Blog\CategoryController@index');
    Route::post('blog/categories', 'Api\Blog\CategoryController@store');
    Route::put('blog/categories/{category}', 'Api\Blog\CategoryController@update');
    Route::delete('blog/categories/{category}', 'Api\Blog\CategoryController@destroy');

    Route::get('blog/tags', 'Api\Blog\TagController@index');
    Route::post('blog/tags', 'Api\Blog\TagController@store');
    Route::put('blog/tags/{category}', 'Api\Blog\TagController@update');
    Route::delete('blog/tags/{category}', 'Api\Blog\TagController@destroy');

    Route::get('blog/articles', 'Api\Blog\ArticleController@index');
    Route::post('blog/articles', 'Api\Blog\ArticleController@store');
    Route::put('blog/articles/{article}', 'Api\Blog\ArticleController@update');
    Route::delete('blog/articles/{article}', 'Api\Blog\ArticleController@destroy');
});
