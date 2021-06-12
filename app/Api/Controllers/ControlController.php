<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Property;
use App\Models\Records;
use Illuminate\Support\Str;

/**
 * Class DeviceController
 * @package App\Http\Controllers\Bindings
 */
class ControlController extends Controller
{
    protected $property;
    protected $meta;
   
    public function controlProperty(Request $request, $hostname, $propertyID, $feature, $value = null)
    {
        $value = strtolower($value);
        $feature = STR::camel($feature);
        $propertyID = (int)$propertyID;
        $this->request = $request;

        // Get all the metadata of the property to be controlled.
        $this->meta['device'] = Device::where('hostname', $hostname)->first();
        $this->meta['property'] = Property::where('id', (int)$propertyID)->where('device_id', $this->meta['device']->id)->first();
        $this->meta['record'] = Records::where('property_id', $propertyID)->orderBy('id', 'desc')->limit(10)->first();

        // If no device was found, an error message is issued.
        if ($this->meta['device'] == null) {
            return '{"status":"error", "message":"device "'.$hostname.'" not found"}';
        }
        if ($this->meta['property'] == null) {
            return '{"status":"error", "message":"property "'.$propertyID.'" not found"}';
        }

        // Concatenate the module's namespace with its binder.
        $classString = 'Modules\\'.$this->meta['property']->binding.'\\Properties\\'.$this->meta['property']->type.'\\'.$this->meta['property']->binding;

        // Catch Error Messages from Property Constructor
        try {
            // Instantiate the class.
            if(!class_exists($classString)){ return '{"status":"error", "message":"binding not found"';}
            $this->property = new $classString($this->meta['property']);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        // Send Request
        $this->property->setRequest(["request"=>$this->request, "value"=>$value]);

        // Call the Feature/Method of class if the feature exists.
        if ($this->property->hasFeature($this->property, $feature) === true) {

            //load property value from database
            if($this->meta['record'] != null){
                $this->property->setState("All", json_decode($this->meta['record']->value, true));
            }
            
            // Certain modules create .env variables. For such cases, we repeat the feature execution 2 times
            $msg = NULL;
            $retries = 2;
            for ($try = 0; $try < $retries; $try++) {
                try {
                    if($value != null){
                        if($this->property->allowedValue($this->property, $feature, $value) == "allowed" ) {
                            if($feature == "state"){
                                $this->property->$feature($value, $this->request->input());   
                            }else{
                                $this->property->$feature($value);
                            } 
                        }else{
                            return '{"status":"error", "message":"only these values are allowed: '.$this->property->allowedValue($this->property, $feature).'"}';
                        }
                    }else{
                        $this->property->$feature();
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

            if(!empty($this->property->getState())){
                Records::insert(['property_id' => $propertyID, 'value' => json_encode($this->property->getState())]);
            }   
            $success = ($this->property->getState($feature) == $value ? "success" : "error");
            return '{"status": "'.$success.'", "value": "'.$this->property->getState($feature).'"}';
        }
        return '{"status":"error", "message":"feature not found"}';
    }
}