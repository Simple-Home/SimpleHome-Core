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
    
    public function save(Request $request, int $location_id = null)
    {
        $validated = $request->validate([
            'positionRadius' => 'required|max:255',
            'postitionLat' => 'required',
            'postitionLong' => 'required',
            'postitionName' => 'required',
        ]);
        
        if ($location_id == null) {
            $location                 = new Locations;
        } else {
            $location                 = Locations::find($location_id);
        }  

        $location->icon           = $request->get('positionIcon');
        $location->name           = $request->get('postitionName');
        $location->radius         = $request->get('positionRadius');

        $location->position       = [
            $request->get('postitionLat'),
            $request->get('postitionLong')
        ];
        
        $location->save();
        
        return redirect()->back()->with('success', (isset($location_id) ? 'Location created.' : 'Location updated.'));
    }
    
    public function remove(int $location_id)
    {
        $location = Locations::find($location_id);
        $location->delete();
        return redirect()->back()->with('danger', 'Location removed.');;
    }
    
    public function listAjax(Request $request)
    {
        if ($request->ajax()) {
            $locations = Locations::all();
            return View::make("system.locations.ajax.list")->with("locations", $locations)->render();
        }
        return redirect()->back();
    }
 
    public function searchAjax(Request $request, $therm = null)
    {
        //TODO: NEED TO BE SUBMITED BY AJAX FIX FOR ALL CONTROLER
        if ($request->ajax()) {
            $locations = Locations::query()
            ->where('name', 'LIKE', "%{$therm}%")
            ->get();

            return View::make("system.locations.ajax.list")->with("locations", $locations)->render();
        }
        return redirect()->back();
    }
    
    public function newAjax(Request $request)
    {
        if ($request->ajax()) {
            return View::make("system.locations.form.edit")->render();
        }
        return redirect()->back();
    }
    
    public function editAjax(int $location_id, Request $request)
    {
        if ($request->ajax()) {
            $location = Locations::find($location_id);
            return View::make("system.locations.form.edit")->with("location", $location)->render();
        }
        return redirect()->back();
    }
}


