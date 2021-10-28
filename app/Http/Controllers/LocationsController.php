<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Storage;
use App\Models\Locations;
use Illuminate\Support\Facades\View;

class LocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('system.locations.index');
    }
    
    public function listAjax(Request $request)
    {
        if ($request->ajax()) {
            $locations = Locations::all();
            return View::make("system.locations.ajax.list")->with("locations", $locations)->render();
        }
        return redirect()->back();
    }
    
    public function create(Request $request)
    {
        $validated = $request->validate([
            'positionRadius' => 'required|max:255',
            'postitionLat' => 'required',
            'postitionLong' => 'required',
            'postitionName' => 'required',
        ]);
        
        $location                 = new Locations;
        $location->name           = $request->get('postitionName');
        $location->radius         = $request->get('positionRadius');
        $location->position       = [
            $request->get('postitionLat'),
            $request->get('postitionLong')
        ];
        
        $location->save();
        return redirect()->back()->with('success', 'Location created.');;;
    }

    public function remove(int $location_id)
    {
        $location = Locations::find($location_id);
        $location->delete();
        return redirect()->back()->with('danger', 'Location removed.');;
    }
}


