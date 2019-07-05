<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('admin.home');

    //Route::get('/create', 'AmoDataController@create')->name('get.amo.create');

    // создание данных в амо (curl) доступно только админу
    Route::post('/create', 'AmoDataController@create')->name('post.amo.create')
        ->middleware('admin');

    // загрузка данных из амо доступна только админу
    Route::get('/upload', 'AmoDataController@upload')->name('amo.upload')
        ->middleware('admin');

    Route::get('/amo-auth', 'AmoDataController@apiAuth')->name('amo.auth');

});
