<?php

namespace App\Http\Controllers;

use App\Helpers\SettingManager;
use App\Models\Properties;
use App\Models\Records;
use App\Models\Rooms;
use App\Models\User;
use App\Notifications\NewDeviceNotification;
use App\Types\GraphPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilder;


class ControlsController extends Controller
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
    public function list(FormBuilder $formBuilder)
    {
        $roomsForm = [];
        $roomForm = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store'),
        ], ['edit' => false]);

        $rooms = Cache::remember('controls.rooms', 1, function () {
            return Rooms::with(['properties' => function ($query) {
                return $query->where('is_hidden', false)->where('is_disabled', false)->select();
            }, 'properties.device' => function ($query) {
                return $query->where('approved', 1)->select('id');
            }])->get(["id", "name"])->filter(function ($item) {
                if ($item->properties->count() > 0 || !SettingManager::get("hideEmptyRooms", "system")->value) {
                    return $item;
                }
            });
        });

        return view('controls.list', compact(
            'rooms',
            'roomForm'
        ));
    }

    public function detail($property_id, $period = GraphPeriod::DAY)
    {
        $propertyDetailChart = null;
        $tableData = [];

        $property = Properties::find($property_id);
        $property->period = $period;

        if ($property->type != 'event' || $property->graphSupport == true) {

            $labels = [];
            $values = [];
            $mins = [];
            $maxs = [];

            foreach ($property->agregated_values  as $key => $item) {
                $values[] = $item->value;
                $mins[] = $item->max;
                $maxs[] = $item->min;

                $labels[] = $item->created_at->diffForHumans(null, true);
            }

            $datasets = [
                [
                    "label" => "value",
                    "backgroundColor" => "rgba(220,220,220,0.5)",
                    "borderColor" => "#1cca50",
                    "tension" => 0.5,
                    //"borderWidth" => 1.2,
                    "pointRadius" => 0,
                    "data" => $values,
                ],
                [
                    "label" => "min",
                    "backgroundColor" => "rgba(220,220,220,0.5)",
                    "borderColor" => "#1cca50",
                    "tension" => 0.5,
                    //"borderWidth" => 1.5,
                    "borderDash" => [5, 5],
                    "pointRadius" => 0,
                    "data" => $mins,
                ],
                [
                    "label" => "max",
                    "backgroundColor" => "rgba(220,220,220,0.5)",
                    "borderColor" => "#1cca50",
                    "tension" => 0.5,
                    //"borderWidth" => 1.5,
                    "borderDash" => [5, 5],
                    "pointRadius" => 0.5,
                    "data" => $maxs,
                ],
            ];

            $rawOptions = "{
                plugins:{
                    maintainAspectRatio: false,
                    spanGaps: false,
                    filler: {
                        propagate: false
                    },
                    legend:{
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            " . (is_int($property->min_value) ? "min: " . ($property->min_value - 5) . "," : "") . "
                            " . (is_int($property->max_value) ? "max: " . ($property->max_value + 5) . "," : "") . "
                            display: false,
                        },
                        grid:{
                            drawBorder: false,
                            display:false,
                        }
                    },
                    x: {
                        ticks: { 
                            display: false,
                        },
                        grid:{
                            drawBorder: false,
                            display:false
                        }
                    }
                },
            }";

            $propertyDetailChart = app()->chartjs
                ->name('propertyDetailChart')
                ->type('line')
                ->labels($labels)
                ->datasets($datasets)
                ->optionsRaw($rawOptions);

            $tableData = $property->agregated_values;
        } else {
            $tableData = $property->values;
        }

        return view('controls.detail', ["table" => $tableData, "property" => $property, "propertyDetailChart" => $propertyDetailChart]);
    }

    public function edit($property_id, FormBuilder $formBuilder)
    {
        $rooms = Rooms::all();
        $sortRooms = array();
        foreach ($rooms as $room) {
            $sortRooms[$room->id] = $room->name;
        }
        $property = Properties::find($property_id);

        $propertyForm = $formBuilder->create(\App\Forms\PropertyForm::class, [
            'model' => $property,
            'method' => 'POST',
            'url' => route('controls.update', ['property_id' => $property_id]),
        ], ['icon' => $property->icon, 'rooms' => $sortRooms]);


        $settings = SettingManager::getGroup('property-' . $property_id);
        $systemSettingsForm = $formBuilder->create(\App\Forms\SettingDatabaseFieldsForm::class, [
            'method' => 'POST',
            'url' => route('controls.settings.update', $property_id),
            'variables' => $settings
        ]);

        return view('controls.edit', compact('property', 'propertyForm', 'systemSettingsForm'));
    }

    public function settingsUpdate(Request $request, FormBuilder $formBuilder, $group = null)
    {
        foreach ($request->input() as $key => $value) {
            if ($key == '_token') {
                continue;
            }

            if (strpos($key, '#') !== false) {
                $index = explode("#", $key)[0];
                $group = explode("#", $key)[1];
            } else {
                $index = $key;
            }

            SettingManager::set($index, $value, $group);
        }

        return redirect()->back()->with('success', 'Property settings sucessfully removed.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\PropertyForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $property = Properties::find($property_id);
        $property->nick_name = $request->input('nick_name');
        $property->icon = $request->input('icon');
        $property->history = $request->input('history');
        $property->units = $request->input('units');
        $property->room_id = $request->input('room_id');

        $property->update();

        return redirect()->route('controls.edit', ['property_id' => $property_id])->with('success', 'Property settings sucessfully updated.');;
    }

    public function remove($property_id)
    {
        $property = Properties::find($property_id);
        $property->delete();

        return redirect()->back()->with('danger', 'Property Sucessfully removed.');
    }

    public function hide($property_id)
    {
        $property = Properties::find($property_id);
        if ($property->is_hidden) {
            $property->show();
            return redirect()->back()->with('danger', 'Property successfully enabled.');
        } else {
            $property->hide();
            return redirect()->back()->with('danger', 'Property successfully disabled.');
        }
    }

    public function enable($property_id)
    {
        $property = Properties::find($property_id);
        if ($property->is_disabled) {
            $property->enable();
            return redirect()->back()->with('danger', 'Property successfully enabled.');
        } else {
            $property->disable();
            return redirect()->back()->with('danger', 'Property successfully disabled.');
        }
    }

    //AJAX
    public function listAjax($room_id = 0, Request $request)
    {
        if ($request->ajax()) {
            $propertyes = Properties::where("room_id", $room_id)->where("is_hidden", false)->where('is_hidden', false)->where('is_disabled', false)->whereHas('device', function ($query) {
                return $query->where('approved', 1);
            })->with(['device' => function ($query) {
                return $query->where('approved', 1)->get(["integration"]);
            }, 'latestRecord'])->get(["id", "device_id", "nick_name", "units", "icon", "type"]);

            return View::make("controls.controls")->with("propertyes", $propertyes)->render();
        }
        return redirect()->back();
    }

    public function roomsAjax($room_id = 0, Request $request)
    {
        if ($request->ajax()) {
            $rooms = Cache::remember('controls.rooms', 1, function () {
                return Rooms::with(['properties', 'properties.device' => function ($query) {
                    $query->select('id');
                    return $query->where('approved', 1);
                }])->get()->filter(function ($item) {
                    if ($item->properties->where('is_hidden', false)->count() > 0 || !SettingManager::get("hideEmptyRooms", "system")->value) {
                        return $item;
                    }
                });
            });
            return View::make("controls.components.subnavigation")->with("rooms", $rooms)->render();
        }
        return redirect()->back();
    }

    public function chartAjax($property_id = 0, Request $request)
    {
        if ($request->ajax()) {
            $property = Properties::find($property_id);

            $labels = [];
            $values = [];

            $property->period = GraphPeriod::DAY;

            foreach ($property->agregated_values  as $key => $item) {
                $values[] = (($item->value < 0) ? abs($item->value) : $item->value);
                $labels[] = $item->created_at->diffForHumans(null, true);
            }

            $datasets = [
                [
                    "fill" => true,
                    "backgroundColor" => ' #1cca50',
                    "tension" => 0.5,
                    "data" => $values,
                ],
            ];

            return response()->json([
                "labels" => $labels,
                "datasets" => $datasets,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
        return redirect()->back();
    }
}
