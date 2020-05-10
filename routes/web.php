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

Route::get('/', function () {
    return view('welcome');
});

Route::get('blog/categories/{slug}', 'Home\Blog\CategoryController@index')->name('home.blog.category');
Route::get('blog/tags/{slug}', 'Home\Blog\TagController@index')->name('home.blog.tag');
