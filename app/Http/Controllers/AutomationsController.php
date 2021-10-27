<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DateTime;
use App\Models\Properties;
use App\Models\Automations;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AutomationsController extends Controller
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

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        return view('automations.index');
    }
    
    public function listAjax($type = "automations", Request $request)
    {
        if ($request->ajax()) {
            $automations = Automations::all();
            return View::make("automations.ajax.list")->with("automations", $automations)->render();
        }
        return redirect()->back();
    }
    
    
    public function remove($automation_id)
    {
        $automations = Automations::find($automation_id);
        $automations->delete();
        return redirect()->route('automations.list');
    }
    
    public function enableAjax($automation_id, Request $request)
    {
        $automation = Automations::find($automation_id);
        $automation->is_enabled = True;
        $automation->save();
        
        if (!$request->ajax()) {
            return redirect()->route('automations.list');
        }
        
        return response()->json([
            "icon" => ($automation->is_enabled == 1 ? "<i class=\"fas fa-toggle-on\"></i>" : "<i class=\"fas fa-toggle-off\"></i>"),
            "url" => route('automations.disable', ['automation_id' => $automation->id]),
        ]);
    }
    
    public function disableAjax($automation_id, Request $request)
    {
        $automation = Automations::find($automation_id);
        $automation->is_enabled = False;
        $automation->save();
        
        if (!$request->ajax()) {
            return redirect()->route('automations.list');
        }
        
        return response()->json([
            "icon" => ($automation->is_enabled == 1 ? "<i class=\"fas fa-toggle-on\"></i>" : "<i class=\"fas fa-toggle-off\"></i>"),
            "url" => route('automations.enable', ['automation_id' => $automation->id]),
        ]);
    }
    
    public function runAjax($automation_id, Request $request){
        $automation = Automations::find($automation_id);
        if ($automation->is_enabled){
            $automation->run_at = Carbon::now();
            $automation->save();
        }
        return redirect()->back();
    }
    
    public function tasksAjax(Request $request)
    {
        if ($request->ajax()) {
            $automationType = $request->input('type');
            return View::make("automations.tasks")->with('automationType', $automationType)->render();
        }
        return redirect()->back();
    }
    
    
    public function propertyesAjax(Request $request)
    {
        
        if ($request->ajax()) {
            $automationType = $request->input('type');
            $propertyes =  Properties::whereIn("type", ["relay", "light", "temperature_control"])->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.properties_selection")->with("propertyes", $propertyes)->with("automationType", $automationType)->render();
        }
        return redirect()->back();
    }
    
    public function rulesAjax(Request $request){
        if ($request->ajax()) {
            $propertyesSelectionIds = $request->input('properties_selection');
            $propertyes =  Properties::whereIn("id", $propertyesSelectionIds)->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.properties_rules")->with("propertyes", $propertyes)->render();
        }
        return redirect()->back();
    }
    
    public function setAjax(Request $request){
        if ($request->ajax()) {
            $propertyesSelectionIds = $request->input('properties_selection');
            $automationType = $request->input('automation_type');
            $propertyes =  Properties::whereIn("id", $propertyesSelectionIds)->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.properties_set")->with("propertyes", $propertyes)->with("automationType", $automationType)->render();
        }
        return redirect()->back();
    }
    
    public function finishAjax(Request $request){
        if ($request->ajax()) {
            $automation = new Automations;
            
            $automation->owner_id = auth()->user()->id;
            $automation->name = "test";
            $automation->conditions = $request->input('automation_type');
            $automation->actions = $request->input('property');
            
            $automation->save();
        }
        return "done";
    }
    
}
