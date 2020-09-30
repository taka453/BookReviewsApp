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

Auth::routes();
Route::get('/', 'ProductController@index')->name('index');
Route::get('/read', 'ProductController@read')->name('read');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/create', 'ProductController@create')->name('create');
    Route::post('/create/store', 'ProductController@store')->name('store');
    Route::get('/edit', 'ProductController@edit')->name('edit');
    Route::post('/edit', 'ProductController@update')->name('update');
    Route::get('/review', 'ProductController@review')->name('review');
    Route::post('/review', 'ProductController@updateComment')->name('updateComment');
    Route::post('/', 'ProductController@delete')->name('destroy');
});

Route::get('/home', 'HomeController@index')->name('home');
