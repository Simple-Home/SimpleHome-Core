<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Rule;
use Illuminate\Http\Request;

/**
 * Class DeviceController
 * @package App\Http\Controllers\Bindings
 */
class DeviceController extends Controller
{

    /**
     * @var
     */
    protected $device;

    /**
     * @var
     */
    protected $meta;

    /**
     * @var
     */
    protected $input;
   
    /**
     * control
     *
     * @param mixed $deviceName
     * @param mixed $feature
     * @param mixed $input
     * @return void
     */
    public function control($deviceName, $feature, $input = null)
    {
        // Set input if it's not NULL
        if (!is_null($input)) {
            $this->input = $input;
        }
        
        $feature = strtolower($feature);

        // Get all the metadata of the device to be controlled.
        $this->meta = Device::where('device', $deviceName)->first();

        // If no device was found, an error message is issued.
        if (empty($this->meta)) {
            return 'Device "' . $deviceName . '" not found';
        }

        // Concatenate the module's namespace with its binder.
        $classString = 'Modules\\' . $this->meta->binding . '\\Device\\' . $this->meta->binding;

         // Catch Error Messages from Device Constructor
        try {
            // Instantiate the class.
            $this->device = new $classString($this->meta);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    
        // Send Input
        $this->device->setInput($this->input);

        // Call the Feature/Method of class if the feature exists.
        if ($this->device->hasFeature($this->device, $feature) === true) {

            // Certain Modules create .env variables. For such cases, we repeat the feature execution 2 times
            $msg = NULL;
            $retries = 2;
            for ($try = 0; $try < $retries; $try++) {
                try {
                    $this->device->$feature();
                } catch (\Exception $ex) {
                    $msg = $ex->getMessage();
                    sleep(1);   
                    continue;
                }
                if ($try == $retries) {
                    return $msg;
                }
                break;
            }

            if(!is_null($this->device->getStatus())){
                Device::where('device', $deviceName)
                    ->update(['state' => $this->device->getStatus()]);
            } 
            $lv_device = Device::where('device', $deviceName)->first();
            $this->device->setStatus($lv_device->state);
            
            return $this->device->getStatus();
        }
        return 'Feature <b>"' . $feature . '"</b> not defined';
    }

    /**
     * create
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                    'devicename' => 'required|unique:devices,device|max:191',
                    'binding' => 'required',
                    'room' => 'exists:rooms,id',
                    'json' => 'json'
                ])->validate();
        
        $data = [
            "devicename" => $request->devicename,
            "binding" => $request->binding,
            "room" => $request->room,
            "json" => $request->json
        ];

        if (\Module::find($data['binding'])) {
            $classString = 'Modules\\' . $data['binding']. '\\Device\\Create' . $data['binding'];
            // Instantiate the class.
            $creator = new $classString($data);
            $creator->create();
            return back();
        }
    }

    /**
     * update
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        if (is_null($request->json)) {
            $validator = \Validator::make($request->all(), [
                'deviceID' => 'required|exists:devices,id',
               // 'devicename' => 'required|unique:devices,device|max:191',
                'binding' => 'required',
                'room' => 'exists:rooms,id'
            ])->validate();
        } else {
            $validator = \Validator::make($request->all(), [
                'deviceID' => 'required|exists:devices,id',
               // 'devicename' => 'required|unique:devices,device|max:191',
                'binding' => 'required',
                'room' => 'exists:rooms,id',
                'json' => 'sometimes|json'
            ])->validate();
        }

        $data = [
                "deviceID" => $request->deviceID,
                "devicename" => $request->devicename,
                "binding" => $request->binding,
                "room" => $request->room,
                "json" => json_decode($request->json, true)
            ];
        
            
        if (\Module::find($data['binding'])) {
            $classString = 'Modules\\' . $data['binding']. '\\Device\\Update' . $data['binding'];
            // Instantiate the class.
            $updater = new $classString($data);
            $updater->update();
            return back();
        }
    }
}