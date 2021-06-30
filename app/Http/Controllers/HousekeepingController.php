<?php

namespace App\Http\Controllers;

use App\Helpers\SettingManager;
use App\Jobs\CleanRecords;
use App\Models\Records;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class HousekeepingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, FormBuilder $formBuilder)
    {

        $records = Records::all();
        $settings['interval'] = SettingManager::get('interval', 'housekeeping');
        $settings['active'] = SettingManager::get('active', 'housekeeping');

        $runJob = $request->get('runJob', false);

        return view('settings.housekeeping', ['records' => $records, 'settings' => $settings, 'runJob' => $runJob]);
    }

    public function saveForm(Request $request)
    {
        $interval = $request->get('housekeeping_interval', 432000);
        $active = $request->get('housekeeping_active', 0);

        SettingManager::set('active', $active, 'housekeeping');
        SettingManager::set('interval', $interval, 'housekeeping');

        return redirect()->route('housekeeping');
    }

    public function cleanRecords()
    {
        CleanRecords::dispatch();
        return redirect()->route('housekeeping', ['runJob' => true]);
    }
}
