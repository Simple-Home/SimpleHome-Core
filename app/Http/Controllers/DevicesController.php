<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;

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

        return view('devices.list', ["devices" => $devices]);
    }
}
