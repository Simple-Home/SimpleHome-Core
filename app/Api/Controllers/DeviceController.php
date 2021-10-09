<?php
namespace App\Api\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Records;
use App\Models\Property;
use App\Models\Device;
use App\Http\Controllers\Controller;

/**
 * Class DeviceController
 * @package App\Http\Controllers\Bindings
 */
class DeviceController extends Controller
{
    public function __construct(){
        $this->middleware('auth:oauth');
    }

    public function getAll(Request $request)
    {
        return Device::all();
    }

    public function getDevice(Request $request, $hostname)
    {
        $count = 0;
        $device['meta'] = Device::where('hostname', $hostname)->first();
        $properties = Property::where('device_id', $device['meta']->id)->get();
        foreach($properties as $property){
            $device['properties'][$count] =  $property;
            $device['properties'][$count]['records'] = Records::where('property_id', $property->id)
                ->orderBy('id', 'desc')->limit(3)->get();
            $count++;
        }
        return $device;
    }

    public function getProperty(Request $request, $hostname, $propertyID)
    {
        $count = 0;
        $device = Device::where('hostname', $hostname)->first();
        $properties = Property::where('id', (int)$propertyID)->where('device_id', $device->id)->get();
        foreach($properties as $property){
            $output['properties'][$count] =  $property;
            $output['properties'][$count]['records'] = Records::where('property_id', $property->id)
                ->orderBy('id', 'desc')->limit(10)->get();
            $count++;
        }
        return $output;
    }

    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'hostname' => 'required|max:191',
            'type' => 'required|max:191',
            'integration' => 'required|max:35',
            'approved' => 'nullable|max:1'
        ])->validate();

        $device = new Device;
        $device->hostname = $request->hostname;
        $device->type = $request->type;
        $device->approved = 0;
        $device->token = '';
        $device->save();

        // Notify the module a new device has been added
        if (\Module::has($request->integration)) {
            $classString = 'Modules\\'.$request->integration.'\\Device\\Device';
            // Instantiate the class.
            $creator = new $classString($device);
            $creator->create();
        }

        return "{}";
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'nullable|numeric|max:20',
            'hostname' => 'required|max:191',
            'type' => 'required|max:191',
            'integration' => 'required|max:35',
            'approved' => 'nullable|max:1'
        ])->validate();

        $device = Device::where('hostname', $request->hostname)->orwhere('id', $request->id)->update(
            [
                'hostname' => $request->new-hostname,
                'type' => $request->type,
                'integration' => $request->integration,
                'approved' => $request->approved
            ]
        );

        // Notify the module a new property has been added
        if (\Module::has($request->integration)) {
            $classString = 'Modules\\'.$request->integration.'\\Device\\Device';
            // Instantiate the class.
            $created = new $classString($device);
            $created->update();
        }

        return "{}";
    }

    public function delete(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'nullable|numeric|max:20',
            'hostname' => 'nullable|max:191'
        ])->validate();

        try {
            $status = Device::where('hostname', $request->hostname)->orwhere('id', $request->id)->delete();
            return '{"status": "'.($status ? "successful" : "error" ).'"}';
        } catch (\Illuminate\Database\QueryException $e) {
            return '{"status":"error", "message":"'.$e.'"}';
        }

        // Notify the module a new device has been deleted
        if (\Module::has($request->integration)) {
            $classString = 'Modules\\'.$request->integration.'\\Device\\Device';
            // Instantiate the class.
            $creator = new $classString($request);
            $creator->delete();
        }
    }
}
