<?php

namespace App\Http\Controllers;

use App\Jobs\CleanRecords;
use App\Models\Configurations;
use App\Models\Properties;
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
        $settings = Configurations::query()
            ->where('configuration_key', 'like', "simplehome.housekeeping%")
            ->get();

        foreach ($settings as $item) {
            $tmp[$item->getAttribute('configuration_key')] = $item->getAttribute('configuration_value');
        }
        unset($settings);
        $settings = $tmp;

        $runJob = $request->get('runJob', false);

        return view('settings.housekeeping', ['records' => $records, 'settings' => $settings, 'runJob' => $runJob]);
    }

    public function saveForm(Request $request)
    {
        $interval = $request->get('simplehome_housekeeping_interval', 432000);
        $active = $request->get('simplehome_housekeeping_active', 0);

        Configurations::where('configuration_key', 'simplehome.housekeeping.interval')->update(['configuration_value' => $interval]);
        Configurations::where('configuration_key', 'simplehome.housekeeping.active')->update(['configuration_value' => $active]);

        return redirect()->route('housekeeping');
    }

    public function cleanRecords()
    {
        CleanRecords::dispatch();
        return redirect()->route('housekeeping', ['runJob' => true]);
    }
}
