<?php

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

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
Route::middleware(['auth', 'verified', 'language'])->get('/users/search', [App\Http\Controllers\UsersController::class, 'search'])->name('users_search');
Route::middleware(['auth', 'verified', 'language'])->post('/user/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
Route::middleware(['auth', 'verified', 'language'])->post('/user/setting', [App\Http\Controllers\UsersController::class, 'setting'])->name('user.setting');
Route::middleware(['auth', 'verified', 'language'])->post('/user/changePassword', [App\Http\Controllers\UsersController::class, 'changePassword'])->name('user.changePassword');
Route::middleware(['auth', 'verified', 'language'])->post('/user/verifyDelete', [App\Http\Controllers\UsersController::class, 'verifyDelete'])->name('user.verifyDelete');
Route::middleware(['auth', 'verified', 'language'])->any('/user/delete/{user?}', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');

Route::namespace('devices')->prefix('devices')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\DevicesController::class, 'list'])->name('devices_list');
    Route::middleware(['auth', 'verified', 'language'])->get('/search', [App\Http\Controllers\DevicesController::class, 'search'])->name('devices_search');
    Route::middleware(['auth', 'verified', 'language'])->get('/detail/{device_id}', [App\Http\Controllers\DevicesController::class, 'detail'])->name('devices_detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/settings/{device_id}', [App\Http\Controllers\DevicesController::class, 'settings'])->name('devices_settings');
    Route::middleware(['auth', 'verified', 'language'])->post('/settings/{device_id}/save', [App\Http\Controllers\DevicesController::class, 'saveSettings'])->name('devices_settings_update');
    Route::middleware(['auth', 'verified', 'language'])->get('/edit/{device_id}', [App\Http\Controllers\DevicesController::class, 'edit'])->name('devices_edit');
    Route::middleware(['auth', 'verified', 'language'])->post('/update/{device_id}', [App\Http\Controllers\DevicesController::class, 'update'])->name('devices_update');
    Route::middleware(['auth', 'verified', 'language'])->post('/update/property/{device_id}', [App\Http\Controllers\DevicesController::class, 'updateProperty'])->name('devices_update_property');
    Route::middleware(['auth', 'verified', 'language'])->post('/store/', [App\Http\Controllers\DevicesController::class, 'store'])->name('devices.store');
    Route::middleware(['auth', 'verified', 'language'])->post('/control/', [App\Http\Controllers\DevicesController::class, 'store'])->name('devices.control');
});

Route::namespace('rooms')->prefix('rooms')->group(function () {
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
    Route::middleware(['auth', 'verified', 'language'])->get('/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('properties_set');;
    Route::middleware(['auth', 'verified', 'language'])->post('/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('properties_set');;
});

Route::namespace('automations')->prefix('automations')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\AutomationsController::class, 'list'])->name('automations_list');
});

Route::namespace('settings')->prefix('settings')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/', [App\Http\Controllers\SettingsController::class, 'dashboard'])->name('server_info');
    Route::middleware(['auth', 'verified', 'language'])->get('/chart/data', [App\Http\Controllers\SettingsController::class, 'chartData'])->name('server_chart_data');
    Route::middleware(['auth', 'verified', 'language'])->get('/integrations', [App\Http\Controllers\SettingsController::class, 'integrations'])->name('integrations_list');
    Route::middleware(['auth', 'verified', 'language'])->get('/integrations/detail/{integration_slug}', [App\Http\Controllers\SettingsController::class, 'detail'])->name('integration_detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/system', [App\Http\Controllers\SettingsController::class, 'system'])->name('system_settings');
    Route::middleware(['auth', 'verified', 'language'])->post('/edit', [App\Http\Controllers\SettingsController::class, 'saveSettings'])->name('settings_update');
    Route::middleware(['auth', 'verified', 'language'])->get('/set/dark', [App\Http\Controllers\SettingsController::class, 'setDark'])->name('settings_dark');
});



//Rewrite
Route::namespace('controls')->prefix('controls')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/room/{room_id?}', [App\Http\Controllers\ControlsController::class, 'list'])->name('controls.room');
    Route::middleware(['auth', 'verified', 'language'])->get('/{property_id}/detail/{period?}', [App\Http\Controllers\ControlsController::class, 'detail'])->name('controls.detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/{property_id}/edit', [App\Http\Controllers\ControlsController::class, 'edit'])->name('controls.edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/{property_id}/remove', [App\Http\Controllers\ControlsController::class, 'remove'])->name('controls.remove');
    Route::middleware(['auth', 'verified', 'language'])->any('/{property_id}/update', [App\Http\Controllers\ControlsController::class, 'update'])->name('controls.update');
    Route::middleware(['auth', 'verified', 'language'])->any('/{property_id}/settings/update', [App\Http\Controllers\ControlsController::class, 'settingsUpdate'])->name('controls.settings.update');
});

Route::namespace('endpoints')->prefix('endpoints')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/endpoints/properties', [App\Http\Controllers\EndpointsController::class, 'propertiesList'])->name('endpoint.properties.list');
    //Simple Home Devices Comands

});

Route::namespace('system')->prefix('system')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/integrations', [App\Http\Controllers\SystemController::class, 'integrationsList'])->name('system.integrations.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/profile', [App\Http\Controllers\UsersController::class, 'edit'])->name('system.user.profile');
    Route::middleware(['auth', 'verified', 'language'])->get('/housekeeping', [App\Http\Controllers\HousekeepingController::class, 'index'])->name('system.housekeepings');
    Route::middleware(['auth', 'verified', 'language'])->post('/housekeeping/save', [App\Http\Controllers\HousekeepingController::class, 'saveForm'])->name('system.housekeepings.save');
    Route::middleware(['auth', 'verified', 'language'])->get('/housekeeping/run', [App\Http\Controllers\HousekeepingController::class, 'cleanRecords'])->name('system.housekeepings.run');

    Route::middleware(['auth', 'verified', 'language'])->get('/users', [App\Http\Controllers\UsersController::class, 'list'])->name('system.users.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/users/search', [App\Http\Controllers\UsersController::class, 'search'])->name('system.users.search');
    Route::middleware(['auth', 'verified', 'language'])->get('/users/{user_id}/remove', [App\Http\Controllers\UsersController::class, 'remove'])->name('system.users.remove');

    Route::middleware(['auth', 'verified', 'language'])->get('/rooms', [App\Http\Controllers\RoomsController::class, 'list'])->name('system.rooms.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/rooms/search', [App\Http\Controllers\RoomsController::class, 'search'])->name('system.rooms.search');
    Route::middleware(['auth', 'verified', 'language'])->get('/rooms/{room_id}/default', [App\Http\Controllers\RoomsController::class, 'default'])->name('system.rooms.default');
    Route::middleware(['auth', 'verified', 'language'])->get('/rooms/{room_id}/remove', [App\Http\Controllers\RoomsController::class, 'remove'])->name('system.rooms.remove');

    Route::middleware(['auth', 'verified', 'language'])->get('/backup', [App\Http\Controllers\BackupController::class, 'backup'])->name('system.backups');
    Route::middleware(['auth', 'verified', 'language'])->get('/devices', [App\Http\Controllers\EndpointsController::class, 'devicesList'])->name('system.devices.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/devices/search', [App\Http\Controllers\EndpointsController::class, 'devicesSearch'])->name('system.devices.search');
    Route::middleware(['auth', 'verified', 'language'])->post('/devices/firmware', [App\Http\Controllers\EndpointsController::class, 'firmware'])->name('system.devices.firmware');

    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/detail', [App\Http\Controllers\EndpointsController::class, 'devicesDetail'])->name('system.devices.detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/edit', [App\Http\Controllers\EndpointsController::class, 'devicesEdit'])->name('system.devices.edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/remove', [App\Http\Controllers\EndpointsController::class, 'deviceRemove'])->name('system.devices.remove');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/command/reboot', [App\Http\Controllers\EndpointsController::class, 'deviceReboot'])->name('others.devices.reboot');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/approve', [App\Http\Controllers\EndpointsController::class, 'deviceApprove'])->name('system.devices.approve');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/disapprove', [App\Http\Controllers\EndpointsController::class, 'deviceDisapprove'])->name('system.devices.disapprove');
    Route::middleware(['auth', 'verified', 'language'])->get('/settings', [App\Http\Controllers\SettingsController::class, 'system'])->name('system.settings.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/developments', [App\Http\Controllers\SettingsController::class, 'developments'])->name('system.developments.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/diagnostics', [App\Http\Controllers\DiagnosticsController::class, 'list'])->name('system.diagnostics.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/diagnostics/chart/data', [App\Http\Controllers\DiagnosticsController::class, 'chartData'])->name('system.diagnostics.chart.data');
    Route::middleware(['auth', 'verified', 'language'])->any('/logs', [App\Http\Controllers\LogsController::class, 'list'])->name('system.logs');
});


//Route::middleware(['auth', 'verified', 'language'])->get('others/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('others.set');;
Route::middleware(['auth', 'verified', 'language'])->post('others/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('others.set');;

#Route::middleware(['auth', 'verified', 'language'])->get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashnoard');

Route::get('/', function () {
    return redirect()->route('controls.room');
});

Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline');
});


//oauth
Route::namespace('oauth')->prefix('oauth')->group(function () {
    Passport::routes();
    Route::get('/redirect', [App\Http\Controllers\OauthContoller::class, 'redirect'])->name('oauth.authorize');
    Route::get('/callback', [App\Http\Controllers\OauthContoller::class, 'callback'])->name('oauth.callback');
    Route::middleware(['auth:oauth'])->get('login', [App\Http\Controllers\PropertiesController::class, 'login'])->name('oauth.login');;
});

Route::middleware(['auth:oauth'])->get('/test', [App\Http\Controllers\UsersController::class, 'test'])->name('oauth.test');
