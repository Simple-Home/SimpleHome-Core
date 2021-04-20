<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Properties;
use App\Http\Controllers\Controller;
use App\Models\Records;
use Illuminate\Support\Facades\Auth;

class EndpointController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data(Request $request)
    {
        $device = Auth::user();
        foreach ($device->getProperties as $key => $property) {
            $propertyType = $property->type;
            if (!empty($request->$propertyType)) {
                dump($propertyType);
                dump($request->$propertyType);

                $record = new Records;
                $record->value = $request->$propertyType;
                $record->property_id = $property->id;
                $record->save();

                dump($property->values);
                #$device->getProperties->values->create(['value' => $request->$propertyType]);
            }
        }
        die(1);
    }

    public function ota()
    {
    }
}
