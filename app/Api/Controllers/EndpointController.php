<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Properties;
use App\Http\Controllers\Controller;
use App\Models\Records;
use Illuminate\Support\Facades\Auth;

class EndpointController extends Controller
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

    public function setup(Request $request)
    {
        $device = Auth::user();
        $device->setHeartbeat();

        foreach ($request->properties as $key => $propertyItem) {
            $property = new Properties;
            $property->type = $propertyItem;
            $property->nick_name = $propertyItem;
            $property->icon = "fas fa-robot";
            $property->device_id = $device->id;
            $property->room_id = 1;
            $property->history = 90;
            $property->save();
        }

        echo json_encode([
            "hostname" => "sada",
            "ip" => "x.x.x.x"
        ]);
    }

    public function data(Request $request)
    {
        $device = Auth::user();
        $device->setHeartbeat();
        foreach ($device->getProperties as $key => $property) {
            $propertyType = $property->type;
            if (!empty($request->$propertyType)) {
                dump($propertyType);
                dump($request->$propertyType);
                $record = new Records;
                $record->value = $request->$propertyType;
                $record->property_id = $property->id;
                $record->save();
                dump($property->values);
                #$device->getProperties->values->create(['value' => $request->$propertyType]);
            }
        }
        die(1);
    }

    public function ota()
    {
    }
}
