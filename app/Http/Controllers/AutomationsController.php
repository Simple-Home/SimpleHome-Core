<?php

namespace App\Http\Controllers;

use App\Models\Automations;
use App\Models\Properties;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
        return redirect()->back();
    }

    public function toggleAjax($automation_id, Request $request)
    {
        $automation = Automations::find($automation_id);
        $automation->is_enabled = !$automation->is_enabled;
        $automation->save();

        if (!$request->ajax()) {
            return redirect()->route('automations.list');
        }

        return ($automation->is_enabled == 1 ? "<i class=\"fas fa-toggle-on\"></i>" : "<i class=\"fas fa-toggle-off\"></i>");
    }

    public function runAjax($automation_id, Request $request)
    {
        $start = microtime(true);
        $result = false;

        $automation = Automations::find($automation_id);
        if (!$automation->is_enabled) {
            return redirect()->back()->with("error", "Automation is not enabled!");
        }

        $automation->run_at = Carbon::now();
        $automation->save();
        $result = $automation->run();

        if ($request->ajax()) {
            return ['false', 'true'][$result];
        }

        return redirect()->back()->with("info", (string)json_encode([
            "result" => $result,
            "execution_time" => (microtime(true) - $start),
        ]));
    }


    /*
    TYPE
    */

    public function saveTypeAjax(Request $request)
    {

        if ($request->ajax()) {
            $automationType = $request->input('type');

            session([
                'automation_creation' => [
                    'type' => $request->input('type'),
                ]
            ]);

            switch ($automationType) {
                case 'state_change':
                    $nextUrl = 'automations.form.triggers.set.ajax';
                    $properties =  Properties::all(["id", "device_id", "nick_name", "units", "icon", "type", "room_id"]);
                    break;

                default:
                    $automationSessionStore = session('automation_creation');
                    $automationSessionStore['triggers'] = 'manual';
                    session(['automation_creation' => $automationSessionStore]);

                    $nextUrl = 'automations.form.actions.set.ajax';
                    $properties =  Properties::whereIn("type", ["relay", "light", "temperature_control"])->get(["id", "device_id", "nick_name", "units", "icon", "type", "room_id"]);
                    break;
            }
            return View::make("automations.modal.properties_selection")->with("properties", $properties)->with("automationType", $automationType)->with("nextUrl", $nextUrl)->render();
        }
        return redirect()->back();
    }

    /*
    TRIGGERS
    */

    public function setTriggersAjax(Request $request)
    {
        if ($request->ajax()) {
            //Save Triggers IDS
            $automationSessionStore = session('automation_creation');
            $automationSessionStore['triggers'] = $request->input('properties_selection');
            session(['automation_creation' => $automationSessionStore]);

            $nextUrl = 'automations.form.actions.creation.ajax';
            $propertyesSelectionIds = $request->input('properties_selection');
            $propertyes =  Properties::whereIn("id", $propertyesSelectionIds)->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.modal.properties_rules")->with("propertyes", $propertyes)->with("nextUrl", $nextUrl)->render();
        }
        return redirect()->back();
    }

    /*
    ACTIONS
    */

    public function selectActionsAjax(Request $request)
    {
        echo "action";
        if ($request->ajax()) {
            //Save Triggers
            $automationSessionStore = session('automation_creation');
            $automationSessionStore['triggers'] = $request->input('property');
            session(['automation_creation' => $automationSessionStore]);

            $automationSessionStore = session('automation_creation');
            $nextUrl = 'automations.form.actions.set.ajax';
            $properties = Properties::whereIn("type", ["relay", "light", "temperature_control"])->get(["id", "device_id", "nick_name", "units", "icon", "type", "room_id"]);
            return View::make("automations.modal.properties_selection")->with("properties", $properties)->with("nextUrl", $nextUrl)->render();
        }
        return redirect()->back();
    }

    public function setActionsAjax(Request $request)
    {
        if ($request->ajax()) {
            //Save actions IDS
            $automationSessionStore = session('automation_creation');
            $automationSessionStore['actions'] = $request->input('properties_selection');
            session(['automation_creation' => $automationSessionStore]);

            $nextUrl = 'automations.form.recap.ajax';
            $propertyesSelectionIds = $request->input('properties_selection');
            $propertyes =  Properties::whereIn("id", $propertyesSelectionIds)->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.modal.properties_set")->with("propertyes", $propertyes)->with("nextUrl", $nextUrl)->render();
        }
        return redirect()->back();
    }

    /*
    RECAP
    */

    public function recapAjax(Request $request, int $automation_id = null)
    {
        //if ($request->ajax()) {
        echo "test";
        //}
        //return redirect()->back();
    }

    /*
    FINISH
    */

    public function finishAjax(Request $request, int $automation_id = null)
    {
        if ($request->ajax()) {
            echo "test";
        }
        return redirect()->back();
    }
}
