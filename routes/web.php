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

Route::get('/', 'ProductController@index');
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/create', 'ProductController@create')->name('create');
    Route::post('/create/store', 'ProductController@store')->name('store');
    Route::get('/review', 'ProductController@review')->name('review');
    Route::post('/review/update', 'ProductController@read')->name('review.update');
});

Route::get('/home', 'HomeController@index')->name('home');
