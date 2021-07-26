<?php

namespace App\Api\Controllers;

use App\Events\DeviceSetupEvent;
use App\Models\Devices;
use App\Models\Properties;
use App\Models\Records;
use App\Models\Rooms;
use Illuminate\Http\JsonResponse;
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
        /** @var Devices $device */
        $device = Auth::user();


        preg_match('/^(?i)Bearer (.*)(?-i)/',$request->header('Authorization'),$token);

        if(!isset($token[1])){
            return response()->json(
                ['error' => __('No token please add Bearer token to header')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $device = Devices::where('token', '=', $token[1])->first();
        if (!$device) {
            $devices            = new Devices;
            $devices->token     = $token[1];
            $devices->hostname  = $token[1];
            $devices->type      = 'custome';
            $devices->save();
            return response()->json(
                [
                  'setup' => true
                ],
                JsonResponse::HTTP_OK
            );
        }

        if ($device->approved == 1) {
            $defaultRoom = Rooms::query()->where('default',1)->first();
            if($defaultRoom === null){

                return response()->json(
                    ['error' => __('No default room configured, please add a default room first')],
                    JsonResponse::HTTP_BAD_REQUEST
                );
            }
            foreach ($request->properties as $key => $propertyItem) {
                if ($device->getPropertiesExistence($propertyItem)) {
                    continue;
                }
                $property               = new Properties;
                $property->type         = $propertyItem;
                $property->nick_name    = $propertyItem;
                $property->icon         = "fas fa-robot";
                $property->device_id    = $device->id;
                $property->room_id      = $defaultRoom->id;
                $property->history      = 90;
                $property->save();
            }
        }

        return  response()->json(
            [
                "hostname"  => $device->getHostname(),
                "sleep"     => $device->sleep,
            ],
            JsonResponse::HTTP_OK
        );
    }

    public function data(Request $request)
    {
        $device = Auth::user();
        $device->setHeartbeat();
        $response = [];

        foreach ($device->getProperties as $key => $property) {
            $propertyType = $property->type;

            if (isset($request->$propertyType) && !is_null($request->$propertyType)) {
                if (!Cache::has($property->id)) {
                    Cache::put($property->id, $request->$propertyType, 1800);
                }

                if ($request->$propertyType != Cache::get($property->id) || !isset($property->last_value)) {
                    $record                 = new Records;
                    $record->value          = $request->$propertyType;
                    $record->property_id    = $property->id;
                    $record->save();
                    Cache::put($property->id, $request->$propertyType, 1800);
                }
            }

            if (!isset($property->last_value->done) || $property->last_value->done == 0) {
                $value = Cache::get($property->id);
                if (!is_null($value)) {
                    $response[$property->type] = $value;
                }
            }
        }

        return response()->json(
            $response,
            JsonResponse::HTTP_OK
        );

    }

    public function depricatedData(Request $request)
    {
        $data = $request->json()->all();
        $device = Devices::query()->where('token', '=', $data['token'])->first();
        $device->setHeartbeat();

        if (!$device) {
            $devices            = new Devices;
            $devices->token     = $data['token'];
            $devices->hostname  = $data['token'];
            $devices->type      = 'custome';
            $devices->save();
            return response()->json(
                [
                  'setup' => true
                ],
                JsonResponse::HTTP_OK
            );
        }

        if ($device->approved == 1) {
            $defaultRoom = Rooms::query()->where('default',1)->first();
            if($defaultRoom === null){

                return response()->json(
                    ['error' => __('No default room configured, please add a default room first')],
                    JsonResponse::HTTP_BAD_REQUEST
                );
            }

            foreach ($data['values'] as $key => $propertyItem) {
                $propertyExit = $device->getPropertiesExistence($key);
                if ($propertyExit = TRUE) {
                    $property               = new Properties;
                    $property->type         = $key;
                    $property->nick_name    = $data['token'];
                    $property->icon         = "fas fa-robot";
                    $property->device_id    = $device->id;
                    $property->room_id      = $defaultRoom->id;
                    $property->history      = 90;
                    $property->save();
                }
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
            $response["values"][$property->type] = (int) $property->last_value->value;
        }


        return response()->json(
            $response,
            JsonResponse::HTTP_OK
        );
    }

    public function ota(Request $request)
    {
        $data["error"] = "Not yet supported";
        return response()->json($data, 200);
    }
}
