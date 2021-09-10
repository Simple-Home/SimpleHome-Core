<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('version-depricated')->prefix('depricated')->group(function () {
    Route::post('/endpoint', [App\Api\Controllers\EndpointController::class, 'depricatedData']);
});

// v1 Device Controller
Route::group(['prefix' => 'v1', 'middleware' => ['throttle:60,1']], function () {
    Route::post('/setup', [App\Api\Controllers\EndpointController::class, 'setup']);
});

// v1 Device Controller
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'throttle:rate_limit,1']], function () {
    Route::post('/data', [App\Api\Controllers\EndpointController::class, 'data']);
    Route::get('/ota', [App\Api\Controllers\EndpointController::class, 'ota']);
});

// OAuth, rate limit 60 requests/min
Route::group(['prefix' => 'v2', 'middleware' => ['cors', 'throttle:10,1']], function () {
    Route::post('/login', [App\Http\Controllers\Auth\ApiAuthenticationController::class, 'login'])->name('api.login');
    //Route::post('/register',[App\Http\Controllers\Auth\ApiAuthenticationController::class, 'register']);
});
Route::group(['prefix' => 'v2', 'middleware' => ['auth:oauth']], function () {
    Route::post('/logout', [App\Http\Controllers\Auth\ApiAuthenticationController::class, 'logout']);
});

// v2 Device Controller, rate limit 60 requests/min
Route::group(['prefix' => 'v2', 'middleware' => ['cors', 'throttle:60,1']], function () {
    //Device Controller
    Route::get('/devices', [App\Api\Controllers\DeviceController::class, 'getAll']);
    Route::get('/device/{hostname}', [App\Api\Controllers\DeviceController::class, 'getDevice']);
    Route::get('/device/{hostname}/{propertyID}', [App\Api\Controllers\DeviceController::class, 'getProperty']);
    Route::post('/device', [App\Api\Controllers\DeviceController::class, 'create']);
    Route::put('/device', [App\Api\Controllers\DeviceController::class, 'update']);
    Route::delete('/device', [App\Api\Controllers\DeviceController::class, 'delete']);

    //Property Controller
    Route::get('/properties', [App\Api\Controllers\PropertyController::class, 'getAll']);
    Route::get('/property/{propertyID}', [App\Api\Controllers\PropertyController::class, 'getProperty']);
    Route::post('/property', [App\Api\Controllers\PropertyController::class, 'create']);
    Route::put('/property', [App\Api\Controllers\PropertyController::class, 'update']);
    Route::delete('/property', [App\Api\Controllers\PropertyController::class, 'delete']);

    //Control Controller
    Route::get('/device/{hostname}/{feature}/{value?}', [App\Api\Controllers\ControlController::class, 'controlProperty'])->name('device.control');

    //Rooms Controller
    Route::get('/rooms', [App\Api\Controllers\RoomController::class, 'getAll']);
    Route::get('/room/{name}', [App\Api\Controllers\RoomController::class, 'getRoom']);
    Route::post('/room', [App\Api\Controllers\RoomController::class, 'create']);
    Route::put('/room', [App\Api\Controllers\RoomController::class, 'update']);
    Route::delete('/room', [App\Api\Controllers\RoomController::class, 'delete']);
});
