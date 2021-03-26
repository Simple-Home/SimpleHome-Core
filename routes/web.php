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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/devices', [App\Http\Controllers\DevicesController::class, 'list'])->name('devices_list');
Route::get('/users', [App\Http\Controllers\UsersController::class, 'list'])->name('users_list');
Route::get('/properties', [App\Http\Controllers\PropertiesController::class, 'list'])->name('properties_list');
Route::get('/server', [App\Http\Controllers\ServerController::class, 'index'])->name('server_info');
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashnoard');



