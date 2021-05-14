<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
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

        foreach ($devices as $key => $device) {
            $device->connection_error = true;

            $heardbeath = new DateTime($device->heartbeat);
            $interval = $heardbeath->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $device->sleep) {
                $device->connection_error = false;
            }
        }

        return view('devices.list', ["devices" => Devices::all()]);
    }

    public function search(Request $request){
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
}
