<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Properties;
use App\Models\Devices;
use DateTime;
use Illuminate\Support\Carbon;

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
    public function devicesList()
    {
        $devices = Devices::all();
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
                if (isset($property->last_value->value)) {
                }
                break;
            }
        }

        return view('endpoints.devices.list', compact('devices'));
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
