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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware(['prefix' => 'v1', 'middleware' => 'auth:api'])->post('/auth', function(){

// });

Route::namespace('version-depricated')->prefix('depricated')->group(function () {
    Route::post('/endpoint', [App\Api\Controllers\EndpointController::class, 'depricatedData']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'throttle:60,1']], function () {
    Route::post('/setup', [App\Api\Controllers\EndpointController::class, 'setup']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'throttle:rate_limit,1']], function () {
    Route::post('/data', [App\Api\Controllers\EndpointController::class, 'data']);
    Route::get('/ota', [App\Api\Controllers\EndpointController::class, 'ota']);
});

//Oauthentication
Route::middleware(['middleware' => 'auth:api'])->get('/authenticate', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::middleware(['middleware' => 'auth:oauth'])->post('/token', [App\Http\Controllers\Auth\AuthController::class, 'login']);
