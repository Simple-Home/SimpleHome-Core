<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'oauth'
], function () {
    //Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::group([
        'middleware' => 'auth:oauth'
    ], function () {
        //Route::get('logout', 'Auth\AuthController@logout');
        //Route::get('user', 'Auth\AuthController@user');
    });
});
