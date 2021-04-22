<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Properties;
use App\Models\Records;

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
            if (!$device->getPropertiesExistence($propertyItem)) {
                $property = new Properties;
                $property->type = $propertyItem;
                $property->nick_name = $propertyItem;
                $property->icon = "fas fa-robot";
                $property->device_id = $device->id;
                $property->room_id = 1;
                $property->history = 90;
                $property->save();
            }
        }

        echo json_encode([
            "hostname" => $device->getHostname(),
            "ip" => "x.x.x.x"
        ]);
    }

    public function data(Request $request)
    {
        $device = Auth::user();
        $device->setHeartbeat();
        $response = [];

        foreach ($device->getProperties as $key => $property) {
            $propertyType = $property->type;
            if (!empty($request->$propertyType)) {
                $record = new Records;
                $record->value = $request->$propertyType;
                $record->property_id = $property->id;
                $record->save();
            }
            if (!empty($property->lastValue)){
                $response[$property->type] = $property->lastValue->id;
            }
        }

        echo json_encode($response);
    }

    public function ota()
    {
    }
}
