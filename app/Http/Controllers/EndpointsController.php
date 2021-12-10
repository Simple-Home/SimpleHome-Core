<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Properties;
use App\Models\User;
use App\Notifications\NewDeviceNotification;
use DateTime;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Kris\LaravelFormBuilder\FormBuilder;

class EndpointsController extends Controller
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
    public function devicesSearch(Request $request, FormBuilder $formBuilder)
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

            $devices[$key]["firmware"] = $formBuilder->create(\App\Forms\FirmwareForm::class, [
                'model' => ["id" => $device->id],
                'method' => 'POST',
                'class' => 'd-flex justify-content-between ml-auto',
                'url' => route('system.devices.firmware'),
            ]);

            $heardbeath = new DateTime($device->heartbeat);
            $interval = $heardbeath->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $device->sleep) {
                $device->connection_error = false;
            }
        }

        return view('system.devices.list', ["devices" => $devices]);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function firmware(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\FirmwareForm::class, [
            'method' => 'POST',
            'url' => route('system.devices.firmware'),
        ]);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $device = Devices::find($request->input('id'));

        $fileUploaded = $request->file('firmware');
        $originalFileName = $fileUploaded->getClientOriginalName();
        $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        if (!isset($device->data->network->mac)) {
            return redirect()->back()->with('danger', 'Mac Address Required for OTA Updates');
        }

        if (file_exists(storage_path('app/firmware/' . $device->id . "-" . md5($device->data->network->mac) . "." . $fileExtension))) {
            unlink(storage_path('app/firmware/' . $device->id . "-" . md5($device->data->network->mac) . "." . $fileExtension));
        }
        Storage::putFileAs('firmware', $fileUploaded, $device->id . "-" . md5($device->data->network->mac) . "." . $fileExtension);

        return redirect()->route('system.devices.list');
    }

    public function devicesList(FormBuilder $formBuilder)
    {
        $devices = Devices::withCount('properties')->get();
        foreach ($devices as $key => $device) {
            $devices[$key]["firmware"] = $formBuilder->create(\App\Forms\FirmwareForm::class, [
                'model' => ["id" => $device->id],
                'class' => 'd-flex justify-content-between ml-auto',
                'method' => 'POST',
                'url' => route('system.devices.firmware'),
            ]);
        }

        return view('system.devices.list', compact('devices'));
    }

    public function devicesDetail(int $device_id, FormBuilder $formBuilder)
    {
        $device = Devices::find($device_id);
        $device->integration = str_replace(" ", "-", strtolower($device->integration));
        $deviceForm = $formBuilder->create(\App\Forms\DeviceForm::class, [
            'model' => $device,
            'method' => 'POST',
            'url' => route('devices_update', ['device_id' => $device_id])
        ]);

        $devices = Devices::get();
        $integrations = [];
        foreach ($devices as $lDevice) {
            $value = str_replace(" ", "-", strtolower($lDevice->integration));
            if (!empty ($value)) {
                $integrations[$value] = $value;
            }
        }

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

        return view('system.devices.detail', compact("device", "deviceForm", "propertyForms", "integrations"));
    }

    public function devicesEdit(int $device_id, FormBuilder $formBuilder)
    {
        $device = Devices::find($device_id);
        $device->integration = str_replace(" ", "-", strtolower($device->integration));
        $deviceForm = $formBuilder->create(\App\Forms\DeviceForm::class, [
            'model' => $device,
            'method' => 'POST',
            'url' => route('devices_update', ['device_id' => $device_id])
        ]);

        $devices = Devices::get();
        $integrations = [];
        foreach ($devices as $lDevice) {
            $value = str_replace(" ", "-", strtolower($lDevice->integration));
            if (!empty ($value)) {
                $integrations[$value] = $value;
            }
        }

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

        return view('system.devices.edit', compact("device", "deviceForm", "propertyForms", "integrations"));
    }
    public function deviceRemove($device_id)
    {
        $device = Devices::find($device_id);
        $device->delete();

        return redirect()->route('system.devices.list')->with('error', 'Device Sucessfully removed.');
    }

    public function deviceReboot($device_id)
    {
        $device = Devices::find($device_id);
        $device->reboot();

        return redirect()->route('system.devices.list')->with('success', 'Reboot command was issued sucessfully.');
    }

    public function deviceApprove($device_id)
    {
        $device = Devices::find($device_id);
        $device->approve();

        return redirect()->route('system.devices.list')->with('success', 'Device was approved sucessfully.');
    }

    public function deviceDisapprove($device_id)
    {
        $device = Devices::find($device_id);
        $device->disapprove();

        return redirect()->route('system.devices.list')->with('error', 'Device command was blocked sucessfully.');
    }

    public function propertiesList()
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

        return view('endpoints.properties.list', compact('properties'));
    }
}
