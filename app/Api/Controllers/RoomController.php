<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\Property;
use App\Models\Records;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

/**
 * Class RoomController
 * @package App\Http\Controllers\Bindings
 */
class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:oauth');
    }

    public function getAll(Request $request)
    {
        return Rooms::all();
    }

    public function getRoom(Request $request, $name)
    {
        $validator = \Validator::make(["name" => $name], [
            'name' => 'required|max:255',
        ])->validate();

        $count = 0;
        $name = str_replace('_', ' ', $name);
        $room['meta'] = Rooms::where('name', $name)->first();
        $properties = Property::where('room_id', $room['meta']->id)->get();
        foreach($properties as $property){
            $room['properties'][$count] =  $property;
            $room['properties'][$count]['records'] = Records::where('property_id', $property->id)
                ->orderBy('id', 'desc')->limit(3)->get();
            $count++;
        }
        return $room;
    }

    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'default' => 'required|max:255',
        ])->validate();

        $room = new Rooms;
        $room->name = $request->name;
        $room->default = $request->default;

        $room->save();
        return "{}";
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'nullable|numeric|max:20',
            'name' => 'nullable|max:255'
        ])->validate();

        Rooms::where('name', $request->name)->orwhere('id', $request->id)->update(['name' => $request->new-name]);
        return "{}";
    }

    public function delete(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'nullable|numeric|max:20',
            'name' => 'nullable|max:255'
        ])->validate();

        try {
            $status = Rooms::where('name', $request->name)->orwhere('id', $request->id)->delete();
            return '{"status": "'.($status ? "successful" : "error" ).'"}';
        } catch (\Illuminate\Database\QueryException $e) {
            return '{"status":"error", "message":"'.$e.'"}';
        }
    }
}
