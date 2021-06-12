<?php

Route::group(['middleware' => 'web', 'prefix' => 'exampleLight', 'namespace' => 'Modules\ExampleBinding\Http\Controllers'], function()
{
    Route::get('/', 'ExampleBindingController@index');
});
