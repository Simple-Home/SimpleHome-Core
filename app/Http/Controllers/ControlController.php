<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\Properties;

class ControlController extends Controller
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
    public function list($room_id = 0)
    {
        $rooms = Rooms::all()->filter(function ($item) {
            if ($item->PropertiesCount > 0) {
                return $item;
            }
        });

        if ($room_id == 0)
            $room_id =  Rooms::min('id');

        $propertyes =  Properties::where("room_id", $room_id)->get();

        return view('control.list', compact('rooms', 'propertyes'));
    }
}
