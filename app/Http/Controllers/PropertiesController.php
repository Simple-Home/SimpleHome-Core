<?php

namespace App\Http\Controllers;

use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Properties;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Property;
use App\Models\Records;
use Illuminate\Support\Str;
use DateTime;
use App\Helpers\SettingManager;

class PropertiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list()
    {
        $properties = Properties::all();

        foreach ($properties as $key => $property) {
            $property->connection_error = true;

            $heartbeat = new DateTime($property->device->heartbeat);
            $interval = $heartbeat->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $property->device->sleep) {
                $property->connection_error = false;
            }

            $property->connection_ago = Carbon::parse($heartbeat, 'Europe/Prague')->diffForHumans();
        }

        return view('properties.list', ["properties" => $properties]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $properties = Properties::query()
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhere('nick_name', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->get();

        foreach ($properties as $key => $property) {
            $property->connection_error = true;

            $heartbeat = new DateTime($property->device->heartbeat);
            $interval = $heartbeat->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $property->device->sleep) {
                $property->connection_error = false;
            }

            $property->connection_ago = Carbon::parse($heartbeat, 'Europe/Prague')->diffForHumans();
        }

        return view('properties.list', ["properties" => $properties]);
    }

    public function detail($property_id)
    {
        $properti = Properties::find($property_id);

        $dataset["data"] = [];
        $labels = [];

        foreach ($properti->agregated_values  as $key => $item) {
            $dataset["data"][] += $item['value'];
            $labels[] = $item['created_at']->diffForHumans();
        }

        $propertyDetailChart = app()->chartjs
            ->name('propertyDetailChart')
            ->type('line')
            ->labels($labels)
            ->datasets([$dataset])
            ->optionsRaw("{
                scales: {
                    yAxes: [{
                        ticks: {
                            min: Math.min.apply(this, " . json_encode($dataset["data"]) . ") - 5,
                            max: Math.max.apply(this, " . json_encode($dataset["data"]) . ") + 5
                        }
                    }]
                }
            }");

        return view('properties.detail', ["table" => $properti->agregated_values, "properti" => $properti, "propertyDetailChart" => $propertyDetailChart]);
    }

    public function edit(Properties $property, FormBuilder $formBuilder)
    {
        $propertyEditForm = $formBuilder->create(\App\Forms\EditPropertyForm::class, [
            'model' => $property,
            'method' => 'POST',
            'url' => route('user.update', ['user' => []])
        ]);
        return view('properties.edit', ['property' => $property] + compact('propertyEditForm'));
    }

    public function set($property_id, $value, Request $request)
    {
        //Values Validator integrate to date types
        if ($settings = SettingManager::get('min', 'property-' . $property_id)) {
            if ($value < $settings->value) {
                return redirect()->back()->with('danger', 'not valid value. value need to be betvene ' . $settings["min"] . " & " . $settings["max"]);
            }
        }

        if ($settings = SettingManager::get('max', 'property-' . $property_id)) {
            if ($value > $settings->value) {
                return redirect()->back()->with('danger', 'not valid value. value need to be betvene ' . $settings["min"] . " & " . $settings["max"]);
            }
        }

        $record                 = new Records;
        $record->value          = $value;
        $record->property_id    = $property_id;
        $record->save();

        if (!$request->ajax()) {
            return redirect()->back();
        }

        $pendingRecordId = $record->id;

        $i = 30;
        $executed = false;
        while (!$executed & $i > 0) {
            usleep(500);
            $pendingRecord = Records::find($pendingRecordId);
            if ($pendingRecord->done == 1) {
                $executed = true;
                //usleep(500);
            }
            $i--;
        }

        return response()->json([
            "value" => $record->value,
            "icon" => ($record->value == "1" ? "<i class=\"fas fa-toggle-on\"></i>" : "<i class=\"fas fa-toggle-off\"></i>"),
            "url" => route('others.set', ['properti_id' => $record->property_id, 'value' => (int) !$record->value]),
        ]);
    }


    public function control(Request $request, $propertyID)
    {
        $value = strtolower($request->value);
        $feature = STR::camel($request->feature);
        $propertyID = (int)$propertyID;
        $this->request = $request;

        // Get all the metadata of the property to be controlled.
        $this->meta['property'] = Property::where('id', $propertyID)->first();
        $this->meta['record'] = Records::where('property_id', $propertyID)->orderBy('id', 'desc')->limit(1)->first();

        //Cant change value of sensor
        if ($this->meta['property']->type == "sensor") {
            return '{"status":"error", "message":"can not change value of sensor"}';
        }

        // If no property was found, an error message is issued.
        if ($this->meta['property'] == null) {
            return '{"status":"error", "message":"property "' . $propertyID . '" not found"}';
        }

        // Concatenate the module's namespace with its binder.
        $classString = 'Modules\\' . $this->meta['property']->binding . '\\Properties\\' . $this->meta['property']->type . '\\' . $this->meta['property']->binding;

        // Catch Error Messages from Property Constructor
        try {
            // Instantiate the class.
            if (!class_exists($classString)) {
                return '{"status":"error", "message":"binding not found"';
            }
            $this->property = new $classString($this->meta);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        // Call the Feature/Method of class if the feature exists.
        if ($this->property->hasFeature($this->property, $feature) === true) {

            //load property value from database
            if ($this->meta['record'] != null) {
                $this->property->setState("All", json_decode($this->meta['record']->value, true));
            }

            // for reliable execution we repeat the feature execution 2 times
            $msg = NULL;
            $retries = 2;
            for ($try = 0; $try < $retries; $try++) {
                try {
                    if ($value != null) {
                        if ($this->property->allowedValue($this->property, $feature, $value) == "allowed") {
                            if ($feature == "state") {
                                $this->property->$feature($value, $this->request->input());
                            } else {
                                $this->property->$feature($value);
                            }
                        } else {
                            return '{"status":"error", "message":"only these values are allowed: ' . $this->property->allowedValue($this->property, $feature) . '"}';
                        }
                    } else {
                        $this->property->$feature();
                    }
                } catch (\Exception $ex) {
                    $msg = $ex->getMessage();
                    sleep(.5);
                    continue;
                }
                if ($try == $retries) {
                    return $msg;
                }
                break;
            }

            if (!empty($this->property->getState())) {
                Records::insert(['property_id' => $propertyID, 'value' => json_encode($this->property->getState())]);
            }
            $success = ($this->property->getState($feature) == $value ? "success" : "error");
            return '{"status": "' . $success . '", "value": "' . $this->property->getState($feature) . '"}';
        }
        return '{"status":"error", "message":"feature not found"}';
    }
}
