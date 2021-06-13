<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Property;
use App\Models\Records;
use Illuminate\Support\Str;
/**
 * Class PropertyController
 * @package App\Http\Controllers\Bindings
 */
class PropertyController extends Controller
{
    protected $property;
    protected $meta;
    protected $input;
   
    public function getAll(Request $request)
    {
        return Property::all();
    }

    public function getProperty(Request $request, $propertyID)
    {
        $count = 0;
        $properties = Property::where('id', (int)$propertyID)->get();
        foreach($properties as $property){
            $device['properties'][$count] =  $property;
            $device['properties'][$count]['records'] = Records::where('property_id', $property->id)
                ->orderBy('id', 'desc')->limit(10)->get();
            $count++;
        }
        return $properties;
    }

    public function create(Request $request, $hostname)
    {
        $device = Device::where('hostname', $hostname)->first();
        if((int)$device->id > 0){
            $validator = \Validator::make($request->all(), [
                'type' => 'required|max:255',
                'binding' => 'required|max:255',
                'icon' => 'nullable|max:255',
                'nick_name' => 'nullable|max:255',
                'room_id' => 'nullable|max:255',
                'settings' => 'nullable|max:255',
            ])->validate();

            $property = new Property;
            $property->type = $request->type;
            $property->binding = $request->binding;
            $property->settings = $request->settings;
            $property->icon = $request->icon;
            $property->nick_name = $request->nick_name;
            $property->room_id = (int)$request->room_id;
            $property->device_id = (int)$device->id;
            $property->history = mt_rand(100,600);
        
            $property->save();
            
            //notify the module a new property has been added
            if (\Module::find($request->binding)) {
                $classString = 'Modules\\'.$request->binding.'\\Properties\\Create'.$request->binding;
                // Instantiate the class.
                $creator = new $classString($property);
                $creator->create();
                return back();
            }
        }else{
            return '{"status":"error", "message":"device hostname not found"}';
        }
    }

    public function update(Request $request, $hostname)
    {

    }

    public function delete(Request $request, $hostname)
    {

    }
}