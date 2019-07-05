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

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('admin.home');

    Route::get('/create', 'AmoDataController@create')->name('get.amo.create');
    Route::post('/create', 'AmoDataController@create')->name('post.amo.create');

    Route::get('/upload', 'AmoDataController@upload')->name('amo.upload');

    Route::get('/amo-auth', 'AmoDataController@apiAuth')->name('amo.auth');

});
