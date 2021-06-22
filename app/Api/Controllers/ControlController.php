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
   
    /**
    * Function controlProperty
    * This is the main function
    */
    public function controlProperty(Request $request, $hostname, $feature, $value = null)
    {
        $this->value = strtolower($value);
        $this->feature = STR::camel($feature);
        $this->request = $request->input();

        // Get all the metadata of the property to be controlled.
        $this->meta['device'] = Device::where('hostname', $hostname)->first();

        // Verify a device with this propery exists
        if ($this->meta['device'] != null) {
            $this->meta['property'] = Property::where('feature', $this->feature)->where('device_id', $this->meta['device']->id)->first();

            if ($this->meta['property'] == null) {
                return '{"status":"error", "message":"a property with the feature "'.$this->feature.'" was not found"}';
            }
        }else{
            return '{"status":"error", "message":"device "'.$hostname.'" not found"}';
        }

        // Instantiate the class.
        $this->instantiateClass();

        // Call the Feature/Method of class if the feature exists.
        if ($this->property->hasFeature($this->property, $this->feature) === true) {

            // Format settings into an array
            $this->meta['property']->settings = json_decode($this->meta['property']->settings, true);
            
            // Save request and value
            $this->property->setRequest(["request" => $this->request, "value" => $this->value]);

            // Call the Binding to control the property
            $this->callIntegration();

            // Save the state the module set
            $this->saveProperty(); 

            // Report
            $status = $this->getSuccessOrFail();
            return '{"status": "'.$status.'", "value": "'.json_encode($this->property->getState()).'"}';
        }
        return '{"status":"error", "message":"feature not found"}';
    }

    /**
    * Function instantiateClass
    */
    private function instantiateClass()
    {
        // Concatenate the module's namespace with its binder.
        $classString = 'Modules\\'.$this->meta['device']->integration.'\\Properties\\'.$this->meta['device']->type.'\\'.$this->meta['device']->integration;

        // Catch Error Messages from Property Constructor
        try {
            // Instantiate the class.
            if (!class_exists($classString)){
                exit('{"status":"error", "message":"Integration not found"');
            }
            $this->property = new $classString($this->meta);
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        }
    }

    /**
    * Function callIntegration
    */
    private function callIntegration() 
    {
        // For reliable execution we repeat the feature execution 2 times
        $msg = NULL;
        $retries = 2;
        for ($try = 0; $try < $retries; $try++) {
            try {
                if ($this->value != null && method_exists($this->property, $this->feature)){
                    if ($this->property->allowedValue($this->property, $this->feature, $this->value) == "allowed" ) {
                        $feature = $this->feature;
                        if ($this->feature == "state"){
                            $this->property->state($this->value, $this->request);
                        } else {
                            $this->property->$feature($this->value);
                        }
                    } else {
                        exit('{"status":"error", "message":"only these values are allowed: '.$this->property->allowedValue($this->property, $this->feature).'"}');
                    }
                } else {
                    $this->property->$feature();
                }     
            } catch (\Exception $ex) {
                $msg = $ex->getMessage();
                sleep(.5);   
                continue;
            }
            if ($try == $retries) {
                exit($msg);
            }
            break;
        }      
    }

    /**
    * Function saveProperty
    */
    private function saveProperty()
    {
        // Get each features property ID
        $propertyRow = Property::where('device_id', $this->meta['device']->id)->get();
        foreach($propertyRow as $propertyItem){
            $propertyID[$propertyItem->feature] = $propertyItem->id;
        }

        // Save the state the module set
        if (!empty($this->property->getState())){
            $propertyValue = $this->property->getState();
            
            foreach ($propertyValue as $feature => $value){
                if($feature == "attributes") continue;
                if(array_key_exists($feature, $propertyID)){
                    Records::insert(['property_id' => $propertyID[$feature], 'value' => $value]);
                }
            }
        }  
    }

    private function getSuccessOrFail()
    {   
        // Fix this, needs real status
        return "success";
    }
}