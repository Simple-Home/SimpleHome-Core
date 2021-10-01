<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Properties;
use App\Models\Devices;
use DateTime;
use Illuminate\Support\Carbon;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Storage;
use File;

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
        
        if (file_exists(storage_path('app/firmware/' . $device->id . "-" . $device->token . "." . $fileExtension))) {
            unlink (storage_path('app/firmware/' . $device->id . "-" . $device->token . "." . $fileExtension));
        }
        Storage::putFileAs('firmware', $fileUploaded, $device->id . "-" . $device->token . "." . $fileExtension);

        return redirect()->route('system.devices.list');
    }

    public function devicesList(FormBuilder $formBuilder)
    {
        $devices = Devices::all();
        foreach ($devices as $key => $device) {
            $device->connection_error = true;

            $devices[$key]["firmware"] = $formBuilder->create(\App\Forms\FirmwareForm::class, [
                'model' => ["id" => $device->id],
                'class' => 'd-flex justify-content-between ml-auto',
                'method' => 'POST',
                'url' => route('system.devices.firmware'),
            ]);

            $heartbeat = new DateTime($device->heartbeat);
            $sleep = empty($device->sleep) ? 1 : $device->sleep;
            $heartbeat->modify('+' . $sleep . ' ms');
            $now = new DateTime();

            if ($heartbeat->getTimestamp() >= $now->getTimestamp()) {
                $device->connection_error = false;
            }

            foreach ($device->getProperties as $property) {
                if (isset($property->last_value->value)) {
                }
                break;
            }
        }

        return view('system.devices.list', compact('devices'));
    }

    public function devicesDetail(int $device_id, FormBuilder $formBuilder)
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

        return view('system.devices.detail', compact("device", "deviceForm", "propertyForms"));
    }

    public function devicesEdit(int $device_id, FormBuilder $formBuilder)
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

        return view('system.devices.edit', compact("device", "deviceForm", "propertyForms"));
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
