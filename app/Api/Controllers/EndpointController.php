<?php

namespace App\Api\Controllers;

use App\Models\Devices;
use App\Models\Records;
use App\Models\Properties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            if ($device->getPropertiesExistence($propertyItem)) {
                continue;
            }
            $property               = new Properties;
            $property->type         = $propertyItem;
            $property->nick_name    = $propertyItem;
            $property->icon         = "fas fa-robot";
            $property->device_id    = $device->id;
            $property->room_id      = 1;
            $property->history      = 90;
            $property->save();
        }

        echo json_encode([
            "hostname"  => $device->getHostname(),
            "sleep"     => $device->sleep,
        ]);
    }

    public function data(Request $request)
    {
        $device = Auth::user();
        $device->setHeartbeat();
        $response = [];

        foreach ($device->getProperties as $key => $property) {
            $propertyType = $property->type;
            $lastValue = $property->lastValue->value;

            if (!empty($request->$propertyType) && ($request->$propertyType != Cache::get($device->id . ":" . $property->id))) {
                $record                 = new Records;
                $record->value          = $request->$propertyType;
                $record->property_id    = $property->id;
                $record->save();
                Cache::put($device->id . ":" . $property->id, $request->$propertyType, 1800);
            }

            if (Cache::has($device->id . ":" . $property->id)) {
                $response[$property->type] = Cache::get($device->id . ":" . $property->id);
            } else {
                $response[$property->type] = $lastValue;
                Cache::put($device->id . ":" . $property->id, $request->$propertyType, 1800);
            }
        }

        echo json_encode($response);
    }

    public function ota(Request $request)
    {
    }
}
