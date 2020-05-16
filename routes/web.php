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

Route::get('/', 'HomeController@index');

Route::get('/admin/{any}', 'AdminController@index')->where('any', '(.*)')->name('admin');

Route::get('blog/categories/{slug}', 'Home\Blog\CategoryController@index')->name('home.blog.category');
Route::get('blog/tags/{slug}', 'Home\Blog\TagController@index')->name('home.blog.tag');
Route::get('blog/article/{slug}', 'Home\Blog\ArticleController@index')->name('home.blog.article');

Route::get('resizes/{size}/{imagePath}', 'ImageController@flyResize')->where('imagePath', '(.*)');
