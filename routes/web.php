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

Route::middleware(['auth', 'verified'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'verified'])->get('/users', [App\Http\Controllers\UsersController::class, 'list'])->name('users_list');
Route::middleware(['auth', 'verified'])->get('/users/search', [App\Http\Controllers\UsersController::class, 'search'])->name('users_search');
Route::middleware(['auth', 'verified'])->get('/user', [App\Http\Controllers\UsersController::class, 'edit'])->name('user');
Route::middleware(['auth', 'verified'])->post('/user/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
Route::middleware(['auth', 'verified'])->post('/user/changePassword', [App\Http\Controllers\UsersController::class, 'changePassword'])->name('user.changePassword');
Route::middleware(['auth', 'verified'])->post('/user/verifyDelete', [App\Http\Controllers\UsersController::class, 'verifyDelete'])->name('user.verifyDelete');
Route::middleware(['auth', 'verified'])->any('/user/delete/{user?}', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');

Route::namespace('devices')->prefix('devices')->group(function () {
    Route::middleware(['auth', 'verified'])->get('', [App\Http\Controllers\DevicesController::class, 'list'])->name('devices_list');
    Route::middleware(['auth', 'verified'])->get('/search/', [App\Http\Controllers\DevicesController::class, 'search'])->name('devices_search');
    Route::middleware(['auth', 'verified'])->get('/detail/{device_id}', [App\Http\Controllers\DevicesController::class, 'detail'])->name('devices_detail');
    Route::middleware(['auth', 'verified'])->get('/edit/{device_id}', [App\Http\Controllers\DevicesController::class, 'edit'])->name('devices_edit');
});
Route::namespace('rooms')->prefix('rooms')->group(function () {
    Route::middleware(['auth', 'verified'])->get('', [App\Http\Controllers\RoomsController::class, 'list'])->name('rooms_list');
    Route::middleware(['auth', 'verified'])->get('/search/', [App\Http\Controllers\RoomsController::class, 'search'])->name('rooms_search');
    Route::middleware(['auth', 'verified'])->get('/default/{room_id}', [App\Http\Controllers\RoomsController::class, 'default'])->name('rooms_default');
});
Route::middleware(['auth', 'verified'])->post('/room/store', [App\Http\Controllers\RoomsController::class, 'store'])->name('rooms.store');
Route::middleware(['auth', 'verified'])->any('/room/{id}/update', [App\Http\Controllers\RoomsController::class, 'update'])->name('rooms.update');
Route::middleware(['auth', 'verified'])->any('/room/{id}/delete', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('rooms.delete');
Route::namespace('properties')->prefix('properties')->group(function () {
    Route::middleware(['auth', 'verified'])->get('', [App\Http\Controllers\PropertiesController::class, 'list'])->name('properties_list');
    Route::middleware(['auth', 'verified'])->get('/search/', [App\Http\Controllers\PropertiesController::class, 'search'])->name('properties_search');
    Route::middleware(['auth', 'verified'])->get('/detail/{property_id}', [App\Http\Controllers\PropertiesController::class, 'detail'])->name('properties_detail');
    Route::middleware(['auth', 'verified'])->get('/edit/{property_id}', [App\Http\Controllers\PropertiesController::class, 'edit'])->name('properties_edit');
});

Route::namespace('automations')->prefix('automations')->group(function () {
    Route::middleware(['auth', 'verified'])->get('', [App\Http\Controllers\AutomationsController::class, 'list'])->name('automations_list');
});

Route::middleware(['auth', 'verified'])->get('/server', [App\Http\Controllers\ServerController::class, 'index'])->name('server_info');
Route::middleware(['auth', 'verified'])->get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashnoard');
