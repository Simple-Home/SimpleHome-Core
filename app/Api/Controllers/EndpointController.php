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
        //$this->middleware('auth');
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
            if (empty($request->$propertyType)) {
                continue;
            }

            if (!Cache::has($property->id)) {
                Cache::put($property->id, $request->$propertyType, 1800);
            }

            if ($request->$propertyType != Cache::get($property->id)) {
                $record                 = new Records;
                $record->value          = $request->$propertyType;
                $record->property_id    = $property->id;
                $record->save();
                Cache::put($property->id, $request->$propertyType, 1800);
            }

            $response[$property->type] = Cache::get($property->id);
        }

        echo json_encode($response);
    }

    public function depricatedData(Request $request)
    {
        $data = $request->json()->all();
        $device = Devices::query()->where('token', '=', "{$request->input('token')}")->first();

        foreach ($data['values'] as $key => $propertyItem) {
            if (!$device->getPropertiesExistence($key)) {
                $property               = new Properties;
                $property->type         = $key;
                $property->nick_name    = $data['token'];
                $property->icon         = "fas fa-robot";
                $property->device_id    = $device->id;
                $property->room_id      = 1;
                $property->history      = 90;
                $property->save();
            }
        }

        foreach ($device->getProperties as $key => $property) {
            $propertyType = $property->type;
            if (!isset($data['values'][$propertyType]['value'])) {
                continue;
            }

            $record                 = new Records;
            $record->value          = $data['values'][$propertyType]['value'];
            $record->property_id    = $property->id;
            $record->save();
        }

        $response = [
            "device" => [
                "sleepTime" => $device->sleep,
                "hostname"  => $device->getHostname(),
            ],
            "state"    => "succes",
            "values"    => [],
            "command"   => "null",
        ];

        foreach ($device->getProperties as $key => $property) {
            $response["values"][$property->type] = (int) $property->lastValue->value;
        }

        echo json_encode($response);
    }

    public function ota(Request $request)
    {
    }
}
