<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Properties;
use DateTime;

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

            $heardbeath = new DateTime($property->device->heartbeat);
            $heardbeath->modify('- 1 hour');
            $interval = $heardbeath->diff(new DateTime());
            $totalSeconds = ($interval->format('%h') * 60 + $interval->format('%i'));

            if ($totalSeconds < $property->device->sleep) {
                $property->connection_error = false;
            }

            $property->connection_ago = Carbon::parse($heardbeath, 'Europe/Prague')->diffForHumans();
        }


        return view('properties.list', ["properties" => $properties]);
    }

    public function search(Request $request){
        $search = $request->input('search');

        $properties = Properties::query()
        ->where('id', 'LIKE', "%{$search}%")
        ->orWhere('nick_name', 'LIKE', "%{$search}%")
        ->orWhere('type', 'LIKE', "%{$search}%")
        ->get();

        return view('properties.list', ["properties" => $properties]);
    }
}
