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

// v1 Device Controller
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'throttle:60,1']], function () {
    Route::post('/setup', [App\Api\Controllers\EndpointController::class, 'setup']);
});

// v1 Device Controller
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'throttle:rate_limit,1']], function () {
    Route::post('/data', [App\Api\Controllers\EndpointController::class, 'data']);
    Route::get('/ota', [App\Api\Controllers\EndpointController::class, 'ota']);
});

// v2 Device Controller
Route::group(['prefix' => 'v2', 'middleware' => []], function () {
    //Device Controller
    Route::get('/devices', [App\Api\Controllers\DeviceController::class, 'getAll']);
    Route::get('/device/{hostname}', [App\Api\Controllers\DeviceController::class, 'getDevice']);
    Route::get('/device/{hostname}/{propertyID}', [App\Api\Controllers\DeviceController::class, 'getProperty']); 
    Route::post('/device/create', [App\Api\Controllers\DeviceController::class, 'create']);
    Route::post('/device/update', [App\Api\Controllers\DeviceController::class, 'update']);
    Route::post('/device/delete', [App\Api\Controllers\DeviceController::class, 'delete']);

    //Property Controller
    Route::get('/properties', [App\Api\Controllers\PropertyController::class, 'getAll']);
    Route::get('/property/{propertyID}', [App\Api\Controllers\PropertyController::class, 'getProperty']);
    Route::post('/device/{hostname}/property/create', [App\Api\Controllers\PropertyController::class, 'create']);
    Route::post('/device/{hostname}/property/update', [App\Api\Controllers\PropertyController::class, 'update']);
    Route::post('/device/{hostname}/property/delete', [App\Api\Controllers\PropertyController::class, 'delete']);

    //Control Controller
    Route::get('/device/{hostname}/{propertyID}/{feature}/{value?}', [App\Api\Controllers\ControlController::class, 'controlProperty']);
});

//Oauthentication
Route::middleware(['middleware' => 'auth:api'])->get('/authenticate', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::middleware(['middleware' => 'auth:oauth'])->post('/token', [App\Http\Controllers\Auth\AuthController::class, 'login']);
