<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Rooms;
use App\Models\User;
use App\Models\Properties;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Helpers\SettingManager;
use App\Models\Records;
use App\Types\GraphPeriod;
use App\Notifications\NewDeviceNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
    public function list($room_id = 0, FormBuilder $formBuilder)
    {

        // Auth::user()->notify(new NewDeviceNotification());

        // dd(Auth::user()->notifications);


        $roomsForm = [];
        $roomForm = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store'),
        ], ['edit' => false]);

        $rooms = Cache::remember('controls.rooms', 15, function () {
            return Rooms::with(['properties', 'properties.device' => fn ($query) => $query->where('approved', 1)->get('id')])->get()->filter(function ($item) {
                if ($item->properties->count() > 0 || !SettingManager::get("hideEmptyRooms", "system")->value) {
                    return $item;
                }
            });
        });

        if ($room_id == 0)
            $room_id =  $rooms->min('id');

        $propertyes = Cache::remember('controls.properties' . $room_id, 15, function () use ($room_id) {
            return Properties::where("room_id", $room_id)->with(['device' => fn ($query) => $query->where('approved', 1)->get(["integration"]), 'latestRecord'])->get(["id", "device_id", "nick_name", "units", "icon", "type"]);
        });



        return view('controls.list', compact('rooms', 'propertyes', 'roomForm'));
    }

    public function detail($property_id, $period = GraphPeriod::DAY)
    {

        $property = Properties::find($property_id);

        $labels = [];

        $values = [];
        $mins = [];
        $maxs = [];

        $property->period = $period;
        foreach ($property->agregated_values  as $key => $item) {
            $values[] = $item->value;
            $mins[] = $item->max;
            $maxs[] = $item->min;

            $labels[] = $item->created_at->diffForHumans();
        }

        $datasets = [
            [
                "label" => "value",
                "backgroundColor" => "rgba(220,220,220,0.5)",
                "borderColor" => "rgba(0,0,0,1)",
                //"tension" => 0.4,
                "pointRadius" => 0,
                "data" => $maxs,
                "data" => $values,
            ],
            [
                "label" => "min",
                "backgroundColor" => "rgba(220,220,220,0.5)",
                "borderColor" => "rgba(0,0,0,1)",
                //"tension" => 0.4,
                "pointRadius" => 0,
                "data" => $mins,
            ],
            [
                "label" => "max",
                "backgroundColor" => "rgba(220,220,220,0.5)",
                "borderColor" => "rgba(0,0,0,1)",
                //"tension" => 0.4,
                "pointRadius" => 0,
                "data" => $maxs,
            ],
        ];



        $dataset["fill"] = True;
        $dataset["backgroundColor"] = "rgba(220,220,220,0.5)";
        $dataset["borderColor"] = "rgba(220,220,220,1)";
        $dataset["tension"] = 0.4;
        $dataset["pointRadius"] = 0;

        $propertyDetailChart = app()->chartjs
            ->name('propertyDetailChart')
            ->type('line')
            ->labels($labels)
            ->datasets($datasets)
            ->optionsRaw("{
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
                    yAxes: [{
                        ticks: {
                            min: Math.min.apply(this, " . json_encode($mins) . ") - 5,
                            max: Math.max.apply(this, " . json_encode($maxs) . ") + 5
                        }
                    }]
                }
            }");

        return view('controls.detail', ["table" => $property->agregated_values, "property" => $property, "propertyDetailChart" => $propertyDetailChart]);
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

    public function settingsUpdate(Request $request, FormBuilder $formBuilder)
    {
        foreach ($request->input() as $key => $value) {
            if ($key == '_token') {
                continue;
            }
            SettingManager::set($key, $value);
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

        return redirect()->route('controls.room')->with('danger', 'Property Sucessfully removed.');
    }
}
