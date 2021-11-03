<?php

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;
use App\Notifications\DeviceRebootNotification;
use App\Models\Devices;

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

Route::middleware(['auth', 'verified', 'language'])->any('',  function () {
    return redirect()->route('controls.list');
});

Auth::routes();
Auth::routes(['verify' => true]);

Route::namespace('devices')->prefix('devices')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/settings/{device_id}', [App\Http\Controllers\DevicesController::class, 'settings'])->name('devices_settings');
    Route::middleware(['auth', 'verified', 'language'])->post('/settings/{device_id}/save', [App\Http\Controllers\DevicesController::class, 'saveSettings'])->name('devices_settings_update');
    Route::middleware(['auth', 'verified', 'language'])->post('/update/{device_id}', [App\Http\Controllers\DevicesController::class, 'update'])->name('devices_update');
    Route::middleware(['auth', 'verified', 'language'])->post('/update/property/{device_id}', [App\Http\Controllers\DevicesController::class, 'updateProperty'])->name('devices_update_property');
    Route::middleware(['auth', 'verified', 'language'])->post('/store/', [App\Http\Controllers\DevicesController::class, 'store'])->name('devices.store');
    Route::middleware(['auth', 'verified', 'language'])->post('/control/', [App\Http\Controllers\DevicesController::class, 'store'])->name('devices.control');
});

Route::namespace('properties')->prefix('properties')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/edit/{property_id}', [App\Http\Controllers\PropertiesController::class, 'edit'])->name('properties_edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/control/{property_id}', [App\Http\Controllers\PropertiesController::class, 'control']);
    Route::middleware(['auth', 'verified', 'language'])->any('/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('properties_set');
});

Route::namespace('automations')->prefix('automations')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\AutomationsController::class, 'list'])->name('automations_list');
});

Route::namespace('users')->prefix('users')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('', [App\Http\Controllers\UsersController::class, 'userLocationsAjax'])->name('users.locators.ajax.list');
});

//Rewrite

//Automations
Route::namespace('automations')->prefix('automations')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/', [App\Http\Controllers\AutomationsController::class, 'index'])->name('automations.index');


    Route::middleware(['auth', 'verified', 'language'])->get('/{automation_id}/remove', [App\Http\Controllers\AutomationsController::class, 'remove'])->name('automations.remove');
    Route::middleware(['auth', 'verified', 'language'])->post('/{automation_id}/enable', [App\Http\Controllers\AutomationsController::class, 'enableAjax'])->name('automations.enable');
    Route::middleware(['auth', 'verified', 'language'])->post('/{automation_id}/disable', [App\Http\Controllers\AutomationsController::class, 'disableAjax'])->name('automations.disable');
    Route::middleware(['auth', 'verified', 'language'])->get('/{automation_id}/run', [App\Http\Controllers\AutomationsController::class, 'runAjax'])->name('automations.run');

    Route::middleware(['auth', 'verified', 'language'])->post('/list/{type}/ajax', [App\Http\Controllers\AutomationsController::class, 'listAjax'])->name('automations.ajax.list');
    
    Route::middleware(['auth', 'verified', 'language'])->get('/tasks/ajax', [App\Http\Controllers\AutomationsController::class, 'tasksAjax'])->name('automations.tasks');
    
    Route::middleware(['auth', 'verified', 'language'])->get('/properties/selection/ajax', [App\Http\Controllers\AutomationsController::class, 'propertyesAjax'])->name('automations.propertie.selection');
    Route::middleware(['auth', 'verified', 'language'])->post('/properties/rules/ajax', [App\Http\Controllers\AutomationsController::class, 'rulesAjax'])->name('automations.propertie.rules');
    Route::middleware(['auth', 'verified', 'language'])->post('/properties/set/ajax', [App\Http\Controllers\AutomationsController::class, 'setAjax'])->name('automations.propertie.set');
    Route::middleware(['auth', 'verified', 'language'])->post('/properties/finish/ajax', [App\Http\Controllers\AutomationsController::class, 'finishAjax'])->name('automations.propertie.finish');

});

//Notifications
Route::namespace('notifications')->prefix('notifications')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/', [App\Http\Controllers\NotificationsController::class, 'list'])->name('notifications.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/count/ajax', [App\Http\Controllers\NotificationsController::class, 'countAjax'])->name('notifications.ajax.count');
    Route::middleware(['auth', 'verified', 'language'])->post('/{notification_id}/read', [App\Http\Controllers\NotificationsController::class, 'read'])->name('notifications.read');
    Route::middleware(['auth', 'verified', 'language'])->post('/{notification_id}/delete', [App\Http\Controllers\NotificationsController::class, 'remove'])->name('notifications.delete');
});

//Controls
Route::namespace('controls')->prefix('controls')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/', [App\Http\Controllers\ControlsController::class, 'list'])->name('controls.list');
    Route::middleware(['auth', 'verified', 'language'])->post('/room/{room_id}/ajax', [App\Http\Controllers\ControlsController::class, 'listAjax'])->name('controls.ajax.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/{property_id}/detail/{period?}', [App\Http\Controllers\ControlsController::class, 'detail'])->name('controls.detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/{property_id}/edit', [App\Http\Controllers\ControlsController::class, 'edit'])->name('controls.edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/{property_id}/remove', [App\Http\Controllers\ControlsController::class, 'remove'])->name('controls.remove');
    Route::middleware(['auth', 'verified', 'language'])->any('/{property_id}/update', [App\Http\Controllers\ControlsController::class, 'update'])->name('controls.update');
    Route::middleware(['auth', 'verified', 'language'])->any('/{property_id}/settings/update', [App\Http\Controllers\ControlsController::class, 'settingsUpdate'])->name('controls.settings.update');
});

//Rooms
Route::namespace('room')->prefix('room')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->post('/store', [App\Http\Controllers\RoomsController::class, 'store'])->name('rooms.store');
    Route::middleware(['auth', 'verified', 'language'])->any('/{id}/update', [App\Http\Controllers\RoomsController::class, 'update'])->name('rooms.update');
    Route::middleware(['auth', 'verified', 'language'])->any('/{id}/delete', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('rooms.delete');
});

//System Settings
Route::namespace('system')->prefix('system')->group(function () {
    Route::middleware(['auth', 'verified', 'language'])->get('/refresh-csrf', function() {
        // if ($request->header('X-CSRF-TOKEN') != csrf_token()) {
        // }
        return response()->json(['token' => csrf_token()]);
    })->name('system.refresh.csrf');
    Route::middleware(['auth', 'verified', 'language'])->get('/housekeeping', [App\Http\Controllers\HousekeepingController::class, 'index'])->name('system.housekeepings');
    Route::middleware(['auth', 'verified', 'language'])->post('/housekeeping/save', [App\Http\Controllers\HousekeepingController::class, 'saveForm'])->name('system.housekeepings.save');
    Route::middleware(['auth', 'verified', 'language'])->get('/housekeeping/records/run', [App\Http\Controllers\HousekeepingController::class, 'cleanRecords'])->name('system.housekeepings.records.run');
    Route::middleware(['auth', 'verified', 'language'])->get('/housekeeping/logs/run', [App\Http\Controllers\HousekeepingController::class, 'cleanLogs'])->name('system.housekeepings.logs.run');

    Route::middleware(['auth', 'verified', 'language'])->get('/users', [App\Http\Controllers\UsersController::class, 'list'])->name('system.users.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/users/search', [App\Http\Controllers\UsersController::class, 'search'])->name('system.users.search');
    Route::middleware(['auth', 'verified', 'language'])->get('/users/{user_id}/remove', [App\Http\Controllers\UsersController::class, 'remove'])->name('system.users.remove');
    Route::middleware(['auth', 'verified', 'language'])->post('/user/storage', [App\Http\Controllers\UsersController::class, 'storage'])->name('system.users.storage');

    Route::middleware(['auth', 'verified', 'language'])->get('/rooms', [App\Http\Controllers\RoomsController::class, 'list'])->name('system.rooms.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/rooms/search', [App\Http\Controllers\RoomsController::class, 'search'])->name('system.rooms.search');
    Route::middleware(['auth', 'verified', 'language'])->get('/rooms/{room_id}/default', [App\Http\Controllers\RoomsController::class, 'default'])->name('system.rooms.default');
    Route::middleware(['auth', 'verified', 'language'])->get('/rooms/{room_id}/remove', [App\Http\Controllers\RoomsController::class, 'remove'])->name('system.rooms.remove');

    Route::middleware(['auth', 'verified', 'language'])->get('/devices', [App\Http\Controllers\EndpointsController::class, 'devicesList'])->name('system.devices.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/devices/search', [App\Http\Controllers\EndpointsController::class, 'devicesSearch'])->name('system.devices.search');
    Route::middleware(['auth', 'verified', 'language'])->post('/devices/firmware', [App\Http\Controllers\EndpointsController::class, 'firmware'])->name('system.devices.firmware');

    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/detail', [App\Http\Controllers\EndpointsController::class, 'devicesDetail'])->name('system.devices.detail');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/edit', [App\Http\Controllers\EndpointsController::class, 'devicesEdit'])->name('system.devices.edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/remove', [App\Http\Controllers\EndpointsController::class, 'deviceRemove'])->name('system.devices.remove');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/command/reboot', [App\Http\Controllers\EndpointsController::class, 'deviceReboot'])->name('others.devices.reboot');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/approve', [App\Http\Controllers\EndpointsController::class, 'deviceApprove'])->name('system.devices.approve');
    Route::middleware(['auth', 'verified', 'language'])->get('/device/{device_id}/disapprove', [App\Http\Controllers\EndpointsController::class, 'deviceDisapprove'])->name('system.devices.disapprove');

    Route::middleware(['auth', 'verified', 'language'])->get('/diagnostics', [App\Http\Controllers\DiagnosticsController::class, 'list'])->name('system.diagnostics.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/diagnostics/chart/data', [App\Http\Controllers\DiagnosticsController::class, 'chartData'])->name('system.diagnostics.chart.data');

    Route::middleware(['auth', 'verified', 'language'])->get('/profile', [App\Http\Controllers\UsersController::class, 'edit'])->name('system.profile');
    Route::middleware(['auth', 'verified', 'language'])->post('/profile/update', [App\Http\Controllers\UsersController::class, 'update'])->name('system.profile.update');
    Route::middleware(['auth', 'verified', 'language'])->post('/profile/setting', [App\Http\Controllers\UsersController::class, 'setting'])->name('system.profile.setting');
    Route::middleware(['auth', 'verified', 'language'])->post('/profile/notification', [App\Http\Controllers\UsersController::class, 'notifications'])->name('system.profile.notifications');
    Route::middleware(['auth', 'verified', 'language'])->post('/profile/changePassword', [App\Http\Controllers\UsersController::class, 'changePassword'])->name('system.profile.changePassword');
    Route::middleware(['auth', 'verified', 'language'])->post('/profile/verifyDelete', [App\Http\Controllers\UsersController::class, 'verifyDelete'])->name('system.profile.verifyDelete');
    Route::middleware(['auth', 'verified', 'language'])->any('/profile/delete/{user}', [App\Http\Controllers\UsersController::class, 'delete'])->name('system.profile.delete');
    Route::middleware(['auth', 'verified', 'language'])->post('/profile/subscribe', [App\Http\Controllers\UsersController::class, 'subscribe'])->name('system.profile.notifications.subscribe');
    
    // Route::middleware(['auth', 'verified', 'language'])->get('/profile/send', function() {
        
    //     $user = auth()->user();
    //     $response = $user->notifyNow(new DeviceRebootNotification(Devices::find(513)));
    //     return response()->json(["status"=>"send","response" => $response]);

    // })->name('notifications.send');

    Route::middleware(['auth', 'verified', 'language'])->get('/integrations', [App\Http\Controllers\SystemController::class, 'integrationsList'])->name('system.integrations.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/integrations/{integration_slug}/detail', [App\Http\Controllers\SettingsController::class, 'detail'])->name('system.integrations.detail');

    Route::middleware(['auth', 'verified', 'language'])->get('/settings', [App\Http\Controllers\SettingsController::class, 'system'])->name('system.settings.list');
    Route::middleware(['auth', 'verified', 'language'])->post('/edit', [App\Http\Controllers\SettingsController::class, 'saveSettings'])->name('system.settings.update');

    Route::middleware(['auth', 'verified', 'language'])->get('/backup', [App\Http\Controllers\BackupController::class, 'backup'])->name('system.backups');
    
    
    Route::middleware(['auth', 'verified', 'language'])->any('/logs', [App\Http\Controllers\LogsController::class, 'list'])->name('system.logs');
    
    
    
    
    
    //DEVILOPMENTS: Main Location route
    Route::middleware(['auth', 'verified', 'language'])->get('/developments', [App\Http\Controllers\DevelopmentsController::class, 'index'])->name('system.developments.index');
    Route::middleware(['auth', 'verified', 'language'])->get('/developments/token/{token_id}/remove', [App\Http\Controllers\DevelopmentsController::class, 'removeToken'])->name('system.developments.token.remove');
    Route::middleware(['auth', 'verified', 'language'])->get('/developments/token/{token_id}/revoke', [App\Http\Controllers\DevelopmentsController::class, 'revokeToken'])->name('system.developments.token.revoke');
    Route::middleware(['auth', 'verified', 'language'])->get('/developments/client/{client_id}/revoke', [App\Http\Controllers\DevelopmentsController::class, 'removeClient'])->name('system.developments.clients.remove');


    //DEVILOPMENTS: Sub Routes for Ajax
    Route::middleware(['auth', 'verified', 'language'])->get('/developments/list/ajax', [App\Http\Controllers\DevelopmentsController::class, 'listAjax'])->name('system.developments.ajax.list');
    Route::middleware(['auth', 'verified', 'language'])->post('/developments/token/personal/new/ajax', [App\Http\Controllers\DevelopmentsController::class, 'newPersonalAjax'])->name('system.developments.personnal.ajax.new');
    Route::middleware(['auth', 'verified', 'language'])->get('/developments/token/new/ajax', [App\Http\Controllers\DevelopmentsController::class, 'newAjax'])->name('system.developments.ajax.new');


    //LOCATIONS: Main Location route
    Route::middleware(['auth', 'verified', 'language'])->any('/locations', [App\Http\Controllers\LocationsController::class, 'index'])->name('system.locations.index');
    Route::middleware(['auth', 'verified', 'language'])->get('/locations/{location_id}/remove', [App\Http\Controllers\LocationsController::class, 'remove'])->name('system.locations.remove');
    Route::middleware(['auth', 'verified', 'language'])->post('/locations/save', [App\Http\Controllers\LocationsController::class, 'save'])->name('system.locations.new');
    Route::middleware(['auth', 'verified', 'language'])->post('/locations/{location_id}/save', [App\Http\Controllers\LocationsController::class, 'save'])->name('system.locations.save');
    //LOCATIONS: Sub Routes for Ajax
    Route::middleware(['auth', 'verified', 'language'])->get('/locations/list/ajax', [App\Http\Controllers\LocationsController::class, 'listAjax'])->name('system.locations.ajax.list');
    Route::middleware(['auth', 'verified', 'language'])->get('/locations/search/ajax/{therm?}', [App\Http\Controllers\LocationsController::class, 'searchAjax'])->name('system.locations.ajax.search');
    Route::middleware(['auth', 'verified', 'language'])->get('/locations/{location_id}/edit/ajax', [App\Http\Controllers\LocationsController::class, 'editAjax'])->name('system.locations.ajax.edit');
    Route::middleware(['auth', 'verified', 'language'])->get('/locations/new/ajax', [App\Http\Controllers\LocationsController::class, 'newAjax'])->name('system.locations.ajax.new');



});

//Route::middleware(['auth', 'verified', 'language'])->get('others/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('others.set');;
Route::middleware(['auth', 'verified', 'language'])->post('others/{properti_id}/set/{value}', [App\Http\Controllers\PropertiesController::class, 'set'])->name('others.set');;


//PWA Routes
Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline');
});

//OAuth Routes
Route::namespace('oauth')->prefix('oauth')->group(function () {
    //Passport::routes();
    Route::get('/redirect', [App\Http\Controllers\OauthContoller::class, 'redirect'])->name('oauth.authorize');
    Route::get('/callback', [App\Http\Controllers\OauthContoller::class, 'callback'])->name('oauth.callback');
    Route::middleware(['auth:oauth'])->get('login', [App\Http\Controllers\PropertiesController::class, 'login'])->name('oauth.login');;
});
