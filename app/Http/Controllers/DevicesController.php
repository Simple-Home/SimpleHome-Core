<?php

namespace App\Http\Controllers;

use App\Helpers\SettingManager;
use App\Models\Devices;
use App\Models\Property;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\FormBuilder;


class DevicesController extends Controller
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
    public function list(FormBuilder $formBuilder)
    {
        $devices = Devices::all();
        $addDeviceForm = $formBuilder->create(\App\Forms\DeviceForm::class, [
            'method' => 'POST',
            'url' => route('devices.store'),
        ], ['edit' => false]);


        #https://www.metageek.com/training/resources/understanding-rssi.html
        
        foreach ($devices as $key => $device) {
            $device->connection_error = true;

            $heartbeat = new DateTime($device->heartbeat);
            $sleep = empty($device->sleep) ? 1 : $device->sleep;
            $heartbeat->modify('+' . $sleep . ' ms');
            $now = new DateTime();

            if ($heartbeat->getTimestamp() >= $now->getTimestamp()) {
                $device->connection_error = false;
            }

            foreach ($device->getProperties as $property) {
                if (isset($property->latestRecord->value)) {
                }
                break;
            }
        }

        return view('devices.list', ["devices" => $devices, "addDeviceForm" => $addDeviceForm]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $devices = Devices::query()
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhere('hostname', 'LIKE', "%{$search}%")
            ->orWhere('token', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->get();

        foreach ($devices as $key => $device) {
            $device->connection_error = true;

            $heardbeath = new DateTime($device->heartbeat);
            $interval = $heardbeath->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $device->sleep) {
                $device->connection_error = false;
            }
        }

        return view('devices.list', ["devices" => $devices]);
    }

    public function detail($device_id, FormBuilder $formBuilder)
    {
        $device = Devices::find($device_id);
        $deviceForm = $formBuilder->create(\App\Forms\DeviceForm::class, [
            'model' => $device,
            'method' => 'POST',
            'url' => route('devices_update', ['device_id' => $device_id])
        ]);

        $propertyForms = [];
        $historyForms = [];
        foreach ($device->getProperties as $property) {
            $propertyForms[$property->id] = $formBuilder->create(\App\Forms\DevicePropertyIconForm::class, [
                'model' => ['id' => $property->id],
                'method' => 'POST',
                'url' => route('devices_update_property', ['device_id' => $device_id])
            ], ['icon' => $property->icon]);

            $historyForms[$property->id] = $formBuilder->create(\App\Forms\DevicePropertyHistoryForm::class, [
                'model' => ['id' => $property->id, 'history' => $property->history],
                'method' => 'POST',
                'url' => route('devices_update_property', ['device_id' => $device_id])
            ]);
        }

        return view('devices.detail', compact("device", "deviceForm", "propertyForms"));
    }

    public function info($device_id)
    {
        $device = Devices::find($device_id);
        return view('system.devices.info', compact("device"));
    }

    public function settings($device_id, FormBuilder $formBuilder)
    {
        $settings = SettingManager::getGroup('device-' . $device_id);

        $systemSettingsForm = $formBuilder->create(\App\Forms\SettingDatabaseFieldsForm::class, [
            'method' => 'POST',
            'url' => route('devices_settings_update', $device_id),
            'variables' => $settings
        ]);

        return view('devices.settings', compact("systemSettingsForm", "settings"));
    }


    public function saveSettings(Request $request, FormBuilder $formBuilder)
    {
        foreach ($request->input() as $key => $value) {
            if ($key == '_token') {
                continue;
            }
            SettingManager::set($key, $value);
        }

        return redirect()->back();
    }

    /**
     * Store the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\DeviceForm::class, [
            'method' => 'POST',
            'url' => route('devices.store'),
        ], ['edit' => false]);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $device = new Devices();
        $device->hostname = $request->input('hostname');
        $device->type = $request->input('type');
        $device->integration = $request->input('integration');
        $device->approved = "1";
        $device->token = "";
        $device->save();

        //notify the module a new device has been added
        if (\Module::has($request->input('integration'))) {
            $classString = 'Modules\\' . $request->input('integration') . '\\Device\\Device';
            // Instantiate the class.
            $creator = new $classString($device);
            $creator->create();
        }

        return redirect()->route('devices_list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $device_id, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\DeviceForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $device = Devices::find($device_id);

        $device->hostname = $request->input('hostname');
        $device->type = $request->input('type');
        $device->integration = str_replace(" ", "-", strtolower($request->input('integration')));
        $device->sleep = $request->input('sleep');
        $device->token = $request->input('token');

        $device->save();
        return redirect()->route('system.devices.detail', ['device_id' => $device_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateProperty(Request $request, $device_id, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\DevicePropertyIconForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $property = Property::find($request->input('id'));
        if (!empty($request->input('icon'))) {
            $property->icon = $request->input('icon');
        }
        if (!empty($request->input('history'))) {
            $property->history = $request->input('history');
        }
        $property->save();

        return redirect()->route('devices_detail', ['device_id' => $device_id]);
    }
}
