<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Rule;
use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Support\Str;
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
     * @param mixed $value
     * @return void
     */
    public function control(Request $request, $deviceName, $feature = null, $value = null)
    {
        // Set input if it's not NULL
        if (!is_null($value)) {
            $this->value = strtolower($value);
        }
        $feature = STR::camel($feature);
        $this->request = $request;

        // Get all the metadata of the device to be controlled.
        $this->meta = Device::where('hostname', $deviceName)->first();

        // If no device was found, an error message is issued.
        if (empty($this->meta)) {
            return 'Error: device "' . $deviceName . '" not found';
        }

        // If no feature was found, display all state
        if (empty($feature)) {
            return json_decode( $this->meta->state, true);
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

        // Send Request
        $this->device->setRequest(["request"=>$this->request, "value"=>$value]);


        // Call the Feature/Method of class if the feature exists.
        if ($this->device->hasFeature($this->device, $feature) === true) {

            //load device state from database
            $this->device->setState("All", json_decode( $this->meta->state, true)); 
            
            // Certain Modules create .env variables. For such cases, we repeat the feature execution 2 times
            $msg = NULL;
            $retries = 2;
            for ($try = 0; $try < $retries; $try++) {
                try {
                    if($this->device->allowedValue($this->device, $feature, $value) == "allowed") {
                        if($feature == "state"){
                            $this->device->$feature($value, $this->request->input());   
                        }else{
                            $this->device->$feature($value);
                        } 
                    }else{
                        return "Error: only these values are allowed: ".$this->device->allowedValue($this->device, $feature);
                    }       
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

            if(!empty($this->device->getState()) ){
                Device::where('hostname', $deviceName)
                    ->update(['state' => $this->device->getState()]);
            }   
            return $this->device->getState($feature);
        }
        return 'Error: feature not defined';
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