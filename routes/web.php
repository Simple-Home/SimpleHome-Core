<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified', 'language'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'verified', 'language'])->get('/users', [App\Http\Controllers\UsersController::class, 'list'])->name('users_list');
Route::middleware(['auth', 'verified', 'language'])->get('/users/search', [App\Http\Controllers\UsersController::class, 'search'])->name('users_search');
Route::middleware(['auth', 'verified', 'language'])->get('/user', [App\Http\Controllers\UsersController::class, 'edit'])->name('user');
Route::middleware(['auth', 'verified', 'language'])->post('/user/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
Route::middleware(['auth', 'verified', 'language'])->post('/user/setting', [App\Http\Controllers\UsersController::class, 'setting'])->name('user.setting');
Route::middleware(['auth', 'verified', 'language'])->post('/user/changePassword', [App\Http\Controllers\UsersController::class, 'changePassword'])->name('user.changePassword');
Route::middleware(['auth', 'verified', 'language'])->post('/user/verifyDelete', [App\Http\Controllers\UsersController::class, 'verifyDelete'])->name('user.verifyDelete');
Route::middleware(['auth', 'verified', 'language'])->any('/user/delete/{user?}', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');

Route::namespace('devices')->prefix('devices')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\DevicesController::class, 'list'])->name('devices_list');
    Route::middleware(['auth', 'verified', 'language'])->get('/search', [App\Http\Controllers\DevicesController::class, 'search'])->name('devices_search');
    Route::middleware(['auth', 'verified', 'language'])->get('/detail/{device_id}', [App\Http\Controllers\DevicesController::class, 'detail'])->name('devices_detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/edit/{device_id}', [App\Http\Controllers\DevicesController::class, 'edit'])->name('devices_edit');
    Route::middleware(['auth', 'verified', 'language'])->post('/update/{device_id}', [App\Http\Controllers\DevicesController::class, 'update'])->name('devices_update');
    Route::middleware(['auth', 'verified', 'language'])->post('/update/property/{device_id}', [App\Http\Controllers\DevicesController::class, 'updateProperty'])->name('devices_update_property');
});

Route::namespace('rooms')->prefix('rooms')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\RoomsController::class, 'list'])->name('rooms_list');
    Route::middleware(['auth', 'verified', 'language'])->get('/search', [App\Http\Controllers\RoomsController::class, 'search'])->name('rooms_search');
    Route::middleware(['auth', 'verified', 'language'])->get('/default/{room_id}/{default}', [App\Http\Controllers\RoomsController::class, 'default'])->name('rooms_default');
});

Route::namespace('room')->prefix('room')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->post('/store', [App\Http\Controllers\RoomsController::class, 'store'])->name('rooms.store');
    Route::middleware(['auth', 'verified', 'language'])->any('/{id}/update', [App\Http\Controllers\RoomsController::class, 'update'])->name('rooms.update');
    Route::middleware(['auth', 'verified', 'language'])->any('/{id}/delete', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('rooms.delete');
});


Route::namespace('properties')->prefix('properties')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\PropertiesController::class, 'list'])->name('properties_list');
    Route::middleware(['auth', 'verified', 'language'])->get('/search', [App\Http\Controllers\PropertiesController::class, 'search'])->name('properties_search');
    Route::middleware(['auth', 'verified', 'language'])->get('/detail/{property_id}', [App\Http\Controllers\PropertiesController::class, 'detail'])->name('properties_detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/edit/{property_id}', [App\Http\Controllers\PropertiesController::class, 'edit'])->name('properties_edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/control/{property_id}', [App\Http\Controllers\PropertiesController::class, 'control']);
});

Route::namespace('automations')->prefix('automations')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\AutomationsController::class, 'list'])->name('automations_list');
});

Route::middleware(['auth', 'verified', 'language'])->get('/settings/', [App\Http\Controllers\SettingsController::class, 'dashboard'])->name('server_info');
Route::middleware(['auth', 'verified', 'language'])->get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashnoard');
