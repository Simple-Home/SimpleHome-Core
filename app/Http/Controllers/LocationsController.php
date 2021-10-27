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
}


