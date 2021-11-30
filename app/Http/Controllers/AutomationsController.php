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
            if ($type == "automations") {
                $automations = Automations::where("conditions", "!=", "")->get(["id", "name", "is_enabled", "run_at"]);
            } elseif ($type == "scenes") {
                $automations = Automations::where("conditions", "")->get(["id", "name", "is_enabled", "run_at"]);
            } else {
                $automations = Automations::all(["id", "name", "is_enabled", "run_at"]);
            }
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

    public function loadAjax(Request $request)
    {
        if ($request->ajax()) {
            return View::make("automations.modal.base")->render();
        }
        return redirect()->back();
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
                    $stepsTotal = 6;
                    break;

                default:
                    $automationSessionStore = session('automation_creation');
                    $automationSessionStore['triggers'] = 'manual';
                    session(['automation_creation' => $automationSessionStore]);

                    $nextUrl = 'automations.form.actions.set.ajax';
                    $properties =  Properties::whereIn("type", ["relay", "light", "temperature_control"])->get(["id", "device_id", "nick_name", "units", "icon", "type", "room_id"]);
                    $stepsTotal = 5;
                    break;
            }
            return View::make("automations.modal.properties_selection")->with("properties", $properties)->with("automationType", $automationType)->with("nextUrl", $nextUrl)->with("stepsTotal", $stepsTotal)->render();
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
        if ($request->ajax()) {
            //Save actions
            $automationSessionStore = session('automation_creation');
            $automationSessionStore['actions'] = $request->input('property');
            session(['automation_creation' => $automationSessionStore]);

            $propertyesTriggers = [];
            $propertyesActions = [];
            $automationName = null;

            if (
                $automation_id == null
            ) {

                if (is_array($automationSessionStore["triggers"])) {
                    foreach ($automationSessionStore["triggers"] as $triggerId => $triggerValues) {
                        $propertyObj = Properties::find($triggerId);

                        $propertyesTriggers[$triggerId] = [
                            "value" => $triggerValues["value"],
                            "operator" => $triggerValues["operator"],
                            "name" => $propertyObj->nick_name,
                            "units" => $propertyObj->units,
                        ];
                    }
                }

                foreach ($automationSessionStore["actions"] as $propertyId => $propertyValue) {
                    $propertyObj = Properties::find($propertyId);
                    $propertyesActions[$propertyId] = [
                        "value" => $propertyValue["value"],
                        "name" => $propertyObj->nick_name,
                        "units" => $propertyObj->units,
                    ];
                }
            } else {
                $automation = Automations::find($automation_id);
                $automationName = $automation->name;

                if (is_object($automation->conditions)) {
                    foreach ((array) $automation->conditions as $triggerId => $triggerValues) {
                        $propertyObj = Properties::find($triggerId);
                        $propertyesTriggers[$triggerId] = [
                            "value" => $triggerValues->value,
                            "operator" => $triggerValues->operator,
                            "name" => $propertyObj->nick_name,
                            "units" => $propertyObj->units,
                        ];
                    }
                }

                foreach ((array) $automation->actions as $propertyId => $propertyValue) {
                    $propertyObj = Properties::find($propertyId);
                    $propertyesActions[$propertyId] = [
                        "value" => $propertyValue->value,
                        "name" => $propertyObj->nick_name,
                        "units" => $propertyObj->units,
                    ];
                }
            }

            //Generate Initial ame
            if ($automationName == null) {
                //TODO: Translate
                $automationName = "simplehome.automation" . "_" . Automations::all()->count();
            }

            $automation = [
                "automation_name" => $automationName,
                "automation_actions" => $propertyesActions,
                "automation_triggers" => $propertyesTriggers,
                "automation_id" => $automation_id,
            ];
            $nextUrl = 'automations.form.finish';
            return View::make("automations.modal.recap")->with("automation", $automation)->with("nextUrl", $nextUrl)->render();
        }
        return redirect()->back();
    }

    /*
    FINISH
    */
    public function finishAjax(Request $request, int $automation_id = null)
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
        session()->forget('automation_creation');
        return "done";
    }
}
