<?php

namespace App\Http\Controllers;

use App\Helpers\SettingManager;
use App\Jobs\CleanRecords;
use App\Models\Records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Kris\LaravelFormBuilder\FormBuilder;

class HousekeepingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, FormBuilder $formBuilder)
    {

        $index = "logs_cleaning_interval";
        if (SettingManager::get($index, 'housekeeping') == null) {
            SettingManager::register($index, 20, 'int', 'housekeeping');
        }
        $index = "logs_cleaning_active";
        if (SettingManager::get($index, 'housekeeping') == null) {
            SettingManager::register($index, false, 'bool', 'housekeeping');
        }
        $index = "interval";
        if (SettingManager::get($index, 'housekeeping') == null) {
            SettingManager::register($index, 432000, 'int', 'housekeeping');
        }
        $index = "active";
        if (SettingManager::get($index, 'housekeeping') == null) {
            SettingManager::register($index, false, 'bool', 'housekeeping');
        }

        $totalRecords = Records::count();
        $totalLogsSize = $this->bytesToHuman($this->dirSize(storage_path('logs/')));

        $settings['logs_cleaning_interval'] = SettingManager::get('logs_cleaning_interval', 'housekeeping');
        $settings['logs_cleaning_active'] = SettingManager::get('logs_cleaning_active', 'housekeeping');
        $settings['interval'] = SettingManager::get('interval', 'housekeeping');
        $settings['active'] = SettingManager::get('active', 'housekeeping');

        $runJob = $request->get('runJob', false);

        return view('system.housekeepings.index', ['totalRecords' => $totalRecords, 'totalLogsSize' => $totalLogsSize, 'settings' => $settings, 'runJob' => $runJob]);
    }

    public function saveForm(Request $request)
    {
        $logs_interval = $request->get('housekeeping_logs_cleaning_interval', 432000);
        $logs_active = $request->get('housekeeping_logs_cleaning_active', 0);
        $interval = $request->get('housekeeping_interval', 432000);
        $active = $request->get('housekeeping_active', 0);

        SettingManager::set('logs_cleaning_active', $logs_active, 'housekeeping');
        SettingManager::set('logs_cleaning_interval', $logs_interval, 'housekeeping');
        SettingManager::set('active', $active, 'housekeeping');
        SettingManager::set('interval', $interval, 'housekeeping');

        return redirect()->back()->with('success', 'Cleaning setting was saved');
    }

    public function cleanRecords()
    {
        if(CleanRecords::dispatch()->onQueue('houskeeping')){
            return redirect()->back()->with('success', __('simplehome.housekeeping.runJob.triggert'));
        }
        return redirect()->back()->with('danger', __('simplehome.housekeeping.runJob.triggert.error'));

    }

    private function dirSize($directory)
    {
        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
    private function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
