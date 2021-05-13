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
Route::middleware(['auth', 'verified'])->get('/user', [App\Http\Controllers\UsersController::class, 'edit'])->name('user');
Route::middleware(['auth', 'verified'])->post('/user/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
Route::middleware(['auth', 'verified'])->post('/user/changePassword', [App\Http\Controllers\UsersController::class, 'changePassword'])->name('user.changePassword');
Route::middleware(['auth', 'verified'])->post('/user/verifyDelete', [App\Http\Controllers\UsersController::class, 'verifyDelete'])->name('user.verifyDelete');
Route::middleware(['auth', 'verified'])->post('/user/delete', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');


Route::middleware(['auth', 'verified'])->get('/devices', [App\Http\Controllers\DevicesController::class, 'list'])->name('devices_list');
Route::middleware(['auth', 'verified'])->get('/devices/search/', [App\Http\Controllers\DevicesController::class, 'search'])->name('devices_search');


Route::middleware(['auth', 'verified'])->get('/properties', [App\Http\Controllers\PropertiesController::class, 'list'])->name('properties_list');
Route::middleware(['auth', 'verified'])->get('/properties/search/', [App\Http\Controllers\PropertiesController::class, 'search'])->name('properties_search');
Route::middleware(['auth', 'verified'])->get('/properties/detail/{property_id}', [App\Http\Controllers\PropertiesController::class, 'detail'])->name('properties_detail');

Route::middleware(['auth', 'verified'])->get('/server', [App\Http\Controllers\ServerController::class, 'index'])->name('server_info');
Route::middleware(['auth', 'verified'])->get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashnoard');



