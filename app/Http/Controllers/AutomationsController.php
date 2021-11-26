<?php

namespace App\Http\Controllers;

use App\Models\Automations;
use App\Models\Properties;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function rulesAjax(Request $request)
    {
        if ($request->ajax()) {
            $propertyesSelectionIds = $request->input('properties_selection');
            $propertyes =  Properties::whereIn("id", $propertyesSelectionIds)->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.properties_rules")->with("propertyes", $propertyes)->render();
        }
        return redirect()->back();
    }

    public function setAjax(Request $request)
    {
        if ($request->ajax()) {
            $propertyesSelectionIds = $request->input('properties_selection');
            $automationType = $request->input('automation_type');
            $propertyes =  Properties::whereIn("id", $propertyesSelectionIds)->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
            return View::make("automations.properties_set")->with("propertyes", $propertyes)->with("automationType", $automationType)->render();
        }
        return redirect()->back();
    }

    public function recapAjax(Request $request, int $automation_id = null)
    {
        if ($request->ajax()) {
            $propertyesTriggers = [];
            $propertyesActions = [];
            $automationName = null;

            if ($automation_id == null) {
                foreach ($request->input('property') as $propertyId => $propertyValue) {
                    $propertyesActions[$propertyId] = [
                        "value" => $propertyValue["value"],
                        "name" => Properties::find($propertyId)->nick_name,
                    ];
                }

                if (!is_array($request->input('automation_type'))) {
                    $propertyesTriggers[] = $request->input('automation_type');
                }
            } else {
                $automation = Automations::find($automation_id);
                $automationName = $automation->name;

                foreach ((array) $automation->actions as $propertyId => $propertyValue) {
                    $propertyesActions[$propertyId] = [
                        "value" => $propertyValue->value,
                        "name" => Properties::find($propertyId)->nick_name,
                    ];
                }

                $propertyesTriggers = $automation->conditions;
            }

            $automation = [
                "automation_name" => $automationName,
                "automation_actions" => $propertyesActions,
                "automation_triggers" => $propertyesTriggers,
                "automation_id" => $automation_id,
            ];

            return View::make("automations.modal.recap")->with("automation", $automation)->render();
        }
        return redirect()->back();
    }


    public function finishAjax(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->input('automation_id'))) {
                $automation = Automations::find($request->input('automation_id'));
            } else {
                $automation = new Automations;
            }

            $automation->owner_id = auth()->user()->id;
            $automation->name = $request->input('automation_name');
            $automation->conditions = $request->input('automation_triggers');
            $automation->actions = $request->input('automation_actions');

            $automation->save();
        }
        return "done";
    }
}
