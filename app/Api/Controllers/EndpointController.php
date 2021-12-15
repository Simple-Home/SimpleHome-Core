<?php

namespace App\Api\Controllers;

use App\Events\DeviceSetupEvent;
use App\Helpers\SettingManager;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Properties;
use App\Models\Records;
use App\Models\Rooms;
use App\Models\User;
use App\Notifications\NewDeviceNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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

        $device = Devices::where('token', '=', $token[1])->first();
        if ($device == null) {
            $devices            = new Devices;
            $devices->token     = $token[1];
            $devices->hostname  = $token[1];
            $devices->type      = 'custome';
            $devices->save();
            $device->setHeartbeat();
            return response()->json(
                [
                    'setup' => true
                ],
                JsonResponse::HTTP_OK
            );
        }
        $device->setHeartbeat();

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
                $property->nick_name    = $device->type . ":" . $propertyItem;
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
        $device = Devices::with('properties:id,type,device_id')->where('token', '=', $data['token'])->first();


        if (!$device) {
            if (empty($data['token'])) {
                Log::error($data);
            }
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
            $this->deviceLog($device->id, "device not approved");
            return response()->json(
                [
                    'approved' => false
                ],
                JsonResponse::HTTP_OK,
                [],
                JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            );
        }

        if (isset($data['logs'])) {
            foreach ($data['logs'] as $log) {
                $this->deviceLog($device->id, $log);
            }
            return response()->json(
                "logs Saved",
                JsonResponse::HTTP_OK,
                [],
                JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            );
        }

        if (isset($data['settings'])) {
            $device->data = $data['settings'];
            $device->save();
        }

        $properties = Cache::remember('api.enpoint.device' . $device->id, 0, function () use ($device) {
            $preparationForCache = $device->properties->pluck("latestRecord.value", "type");
            foreach ($preparationForCache as $type => $value) {
                switch ($type) {
                    case 'relay':
                        unset($preparationForCache[$type]);
                        $preparationForCache["on/off"] = (int) $value;
                        break;

                    case 'temperature_control':
                        unset($preparationForCache[$type]);
                        $preparationForCache["temp_cont"] = (int) $value;
                        break;
                }
            }
            return $preparationForCache;
        });

        if (isset($data['values'])) {
            $device = $this->depricatedCreateProperty($data['values'], $device, $data['token']);

            foreach ($properties as $type => $latestValue) {
                if (!isset($data['values'])) {
                    continue;
                }

                if (!isset($data['values'][$type]) || $latestValue == $data['values'][$type]) {
                    continue;
                }

                if ($data['values'][$type] != 999) {
                    //Error Values Filterring 
                    continue;
                }

                // if (isset($latestRecordLocale)) {
                //     $property->latestRecord->setAsDone();
                // }

                Cache::forget('api.enpoint.device' . $device->id);
                $this->createRecord($device->properties->where("type", ($type == "on/off" ? "relay" : ($type == "temp_cont" ? "temperature_control" : $type)))->first(), $data['values'][$type]['value']);
                $properties[$type] = (int) $data['values'][$type]['value'];

                // TODO: Set all records Before to true
                // if (!$latestRecor->done) {
                //     $latestRecord->setAsDone();
                // }

            }
        }

        $sleepTime = (int) (($device->sleep / 1000) / 60);
        //$sleepTime = ($sleepTime > 0 ? $sleepTime : 1 );

        $response = [
            "device" => [
                "sleepTime" =>  $sleepTime,
                "hostname"  => $device->getHostname(),
            ],
            "state"    => "succes",
            "values"    => $properties,
            "command"   => $device->executeCommand(),
        ];

        return response()->json(
            $response,
            JsonResponse::HTTP_OK,
            [],
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }

    private function depricatedCreateProperty($values, $device, $token)
    {
        foreach ($values as $key => $propertyItem) {
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

                $this->createProperty($device, $defaultRoom, $key, $token);
            }
        }
        return $device;
    }

    public function depricatedOta(Request $request)
    {
        if (!$request->hasHeader('user-agent') || $request->header('user-agent') != 'ESP8266-http-Update') {
            return response()->json(
                "only for ESP8266 updater!",
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        if (
            !$request->hasHeader('x-esp8266-sta-mac') ||
            !$request->hasHeader('x-esp8266-ap-mac') ||
            !$request->hasHeader('x-esp8266-free-space') ||
            !$request->hasHeader('x-esp8266-sketch-size') ||
            !$request->hasHeader('x-esp8266-sketch-md5') ||
            !$request->hasHeader('x-esp8266-chip-size') ||
            !$request->hasHeader('x-esp8266-sdk-version')
        ) {
            return response()->json(
                "only for ESP8266 updater! (header)",
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $device = Devices::where('data->network->mac', $request->header('x-esp8266-sta-mac'))->first();
        if (null == $device) {
            return response()->json(
                "ESP MAC not configured for updates",
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $device->setHeartbeat();

        if (!$device->approved) {
            return response()->json(
                "Device not approved on server",
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $localBinary = storage_path('app/firmware/' . $device->id . "-" . md5($device->data->network->mac) . '.bin');
        if (!file_exists($localBinary)) {
            $this->deviceLog($device->id, "Firmware Image not found");
            return response()->json(
                "Firmware Image not found",
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        if ($request->header('x-esp8266-sketch-md5') == md5_file($localBinary)) {
            $this->deviceLog($device->id, "Same Image Found");
            return response()->json(
                "Same Image Found",
                JsonResponse::HTTP_NOT_MODIFIED
            );
        }

        $file = File::get($localBinary);
        $response = response()->make($file, 200);
        $response->header('Content-Type', 'application/octet-stream');
        $response->header('Content-Disposition', 'attachment; filename=' . basename($localBinary));
        $response->header('Content-Length', filesize($localBinary));
        $response->header('x-MD5', md5_file($localBinary));
        return $response;
    }

    public function ota(String $deviceToken, Request $request)
    {
        //$data = $request->json()->all();

        //$macAddress = $request->header('HTTP_X_ESP8266_STA_MAC');

        if ($device = Devices::where('token', $deviceToken)->get('id') == null) {
            return response(null, 404);
        }

        $localBinary = storage_path('app/firmware/' . $device->id . "-" . md5($device->token) . '.bin'); // . str_replace(':', '', $macAddress) . ".bin";
        if (file_exists($localBinary)) {
            if ($request->header('HTTP_X_ESP8266_SKETCH_MD5') != md5_file($localBinary)) {
                $headers = [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename=' . basename($localBinary),
                    'Content-Length' => filesize($localBinary),
                    'x-MD5' => md5_file($localBinary)
                ];

                return response()->download($localBinary, null, $headers);
            } else {
                return response(null, 304);
            }
        } else {
            return response(null, 404);
        }
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

    private function createRecord($property, $value, $origin = "device")
    {
        $record                 = new Records;
        $record->origin         = "device";
        $record->value          = $value;
        $record->property_id    = $property->id;
        $record->origin         = $origin;
        $record->save();
    }

    function check_header($name, $value = false)
    {
        if (!isset($_SERVER[$name])) {
            return false;
        }
        if ($value && $_SERVER[$name] != $value) {
            return false;
        }
        return true;
    }

    private function deviceLog(int $deviceId, string $data)
    {
        $logFile = storage_path('logs/device:' . $deviceId . "-" . date("Y-m-d") . '.log');
        file_put_contents($logFile, "[" . date("Y-m-d H:m:s") . "]" . $data . PHP_EOL, FILE_APPEND);
    }
}
