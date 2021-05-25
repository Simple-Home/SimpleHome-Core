<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DateTime;


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
    public function list()
    {
        $devices = Devices::all();

        #https://www.metageek.com/training/resources/understanding-rssi.html
        foreach ($devices as $key => $device) {
            $device->connection_error = true;

            $heardbeath = new DateTime($device->heartbeat);
            $interval = $heardbeath->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $device->sleep) {
                $device->connection_error = false;
            }

            foreach ($device->getProperties as $key => $property) {
                if ($property->type != 'wifi') {
                    continue;
                }
                if (isset($property->last_value->value)) {
                }
                break;
            }
            $device->signal_strength = 2 * ($property->last_value->value + 100);
        }

        return view('devices.list', ["devices" => $devices]);
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

        return view('devices.detail', compact("device", "deviceForm"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $device_id, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\DeviceForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $device = Devices::find($id);

        $device->hostname = $request->input('hostname');
        $device->type = $request->input('type');
        $device->sleep = $request->input('sleep');
        $device->token = $request->input('token');

        $device->save();
        return redirect()->route('devices_detail', ['device_id' => $id]);
    }
}
