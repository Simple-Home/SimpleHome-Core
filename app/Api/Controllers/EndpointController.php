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
use App\Helpers\SettingManager;
use App\Models\User;
use App\Notifications\NewDeviceNotification;
use PhpParser\Node\Stmt\Foreach_;

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

        preg_match('/^(?i)Bearer (.*)(?-i)/', $request->header('Authorization'), $token);

        if (!isset($token[1])) {
            return response()->json(
                ['error' => __('No token please add Bearer token to header')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $device = Devices::where('token', '=', $token[1])->first()->id;
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
            $defaultRoom = Rooms::query()->where('default', 1)->first();
            if ($defaultRoom === null) {

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

                if ($request->$propertyType != Cache::get($property->id) || !isset($property->latestRecord)) {
                    $record                 = new Records;
                    $record->value          = $request->$propertyType;
                    $record->property_id    = $property->id;
                    $record->save();
                    Cache::put($property->id, $request->$propertyType, 1800);
                }
            }

            if (!isset($property->latestRecord->done) || $property->latestRecord->done == 0) {
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

        if (!$device) {
            $this->createDevice($data);
            return response()->json(
                [
                    'setup' => true
                ],
                JsonResponse::HTTP_OK
            );

        } 
        
        $device->setHeartbeat();
        if (!$device->approved) {
            return response()->json(
                [
                    'approved' => false
                ],
                JsonResponse::HTTP_OK,
                [],
                JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            );
        }

        if (isset($data['values'])) {
            foreach ($data['values'] as $key => $propertyItem) {
                $propertyExit = $device->getPropertiesExistence(($key == "on/off" ? "relay" : ($key == "temp_cont" ? "temperature_control" : $key)));
                if ($propertyExit == FALSE) {
                    $defaultRoom = Cache::remember('controls.rooms', 15,    function () {
                        return Rooms::query()->where('default', 1)->first();
                    });

                    if ($defaultRoom === null) {
                        return response()->json(
                            ['error' => __('No default room configured, please add a default room first')],
                            JsonResponse::HTTP_BAD_REQUEST
                        );
                    }

                    $this->createProperty($device, $defaultRoom, $key, $data['token']);
                    Cache::put('api.enpoint.properties' . $property->id, $device->getProperties, 15);
                }
            }
        }
        
        $response = [
            "device" => [
                "sleepTime" => (int) ($device->sleep / 1000) / 60,
                "hostname"  => $device->getHostname(),
            ],
            "state"    => "succes",
            "values"    => [],
            "command"   => $device->executeCommand(),
        ];

        $properties = Cache::remember('api.enpoint.properties' . $device->id, 60, function () use ($device) {
             return $device->getProperties;
        });

        $properties = $device->getProperties;
        foreach ($properties as $key => $property) {
            $latestRecordLocale = $property->latestRecord;
            $propertyType = ($property->type == "relay" ? "on/off" : ($property->type == "temperature_control" ? "temp_cont" : $property->type));
            
            if (!isset($data['values'][$propertyType]['value'])) {
                if (isset($latestRecordLocale)) {
                    $response["values"][$propertyType] = (int) $latestRecordLocale->value;
                    if (!$latestRecordLocale->done){
                        Cache::put('api.enpoint.properties' . (int) $latestRecordLocale->value, 60);
                        $latestRecordLocale->setAsDone();
                    }
                    continue;
                }
            }

            if ($latestRecordLocale->value != $data['values'][$propertyType]['value']){
                $this->createRecord($property, $data['values'][$propertyType]['value']);
                $property->latestRecord->setAsDone();
            }
            $response["values"][$propertyType] = $latestRecordLocale->value;
        }

        return response()->json(
            $response,
            JsonResponse::HTTP_OK,
            [],
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }

    public function depricatedOta(Request $request)
    {
        $data = $request->json()->all();

        $macAddress = $request->header('HTTP_X_ESP8266_STA_MAC');
        $localBinary = storage_path('app/firmware/12-asrassrar158.png'); // . str_replace(':', '', $macAddress) . ".bin";

        if (file_exists($localBinary)) {
            if ($request->header('HTTP_X_ESP8266_SKETCH_MD5') != md5_file($localBinary)) {
                $headers = [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename=' . basename($localBinary),
                    'Content-Length' => filesize($localBinary),
                    'x-MD5' => md5_file($localBinary),
                ];
                return response()->download($localBinary, null, $headers);
            } else {
                return response(null, 304);
            }
        } else {
            return response(null, 404);
        }
    }

    public function ota(Request $request)
    {
        $data["error"] = "Not yet supported";
        return response()->json($data, 200);
    }

    private function createDevice($data)
    {
        $devices                    = new Devices;
        $devices->token             = $data['token'];
        $devices->hostname          = $data['token'];
        $devices->integration       = 'others';
        $devices->approved          = 0;

        if (isset($data['values']["on/off"])) {
            $devices->type              = 'relay';
        } elseif (isset($data['values']["temp_cont"])) {
            $devices->type              = 'termostat';
        } else {
            $devices->type              = 'senzor';
        }

        $devices->save();

        foreach (User::all() as $user) {
            $user->notify(new NewDeviceNotification($devices));
        }
    }

    private function createProperty($device, $defaultRoom, $propertyType, $token)
    {
        $property               = new Properties;
        $property->type         = ($propertyType == "on/off" ? "relay" : ($propertyType == "temp_cont" ? "temperature_control" : $propertyType));
        $property->nick_name    = $token;
        $property->icon         = "fas fa-robot";
        $property->device_id    = $device->id;
        $property->room_id      = $defaultRoom->id;
        $property->history      = 90;
        $property->save();

        if ($propertyType == "temp_cont") {
            $group = "property-" . $property->id;
            $settings = [
                "min" => "5",
                "max" => "30",
                "step" => "3",
            ];

            if (isset($settings)) {
                foreach ($settings as $indexs => $value) {
                    if (SettingManager::get($indexs, $group) == false) {
                        SettingManager::register($indexs, $value, 'int', $group);
                    }
                }
            }
        }

        return $property;
    }

    private function createRecord($property, $value, $origin = "device"){
            $record                 = new Records;
            $record->origin         = "device";
            $record->value          = $value;
            $record->property_id    = $property->id;
            $record->origin         = $origin;
            $record->save();
    }
}
