<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Rooms;
use App\Models\Properties;
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
    public function list($room_id = 0, FormBuilder $formBuilder)
    {
        $rooms = Rooms::all();
        $roomsForm = [];
        $roomForm = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store'),
        ], ['edit' => false]);

        $rooms = Rooms::all()->filter(function ($item) {
            //if ($item->PropertiesCount > 0) {
            return $item;
            //}
        });
        if ($room_id == 0)
            $room_id =  Rooms::min('id');

        $propertyes =  Properties::where("room_id", $room_id)->get();

        return view('controls.list', compact('rooms', 'propertyes', 'roomForm'));
    }

    public function detail($property_id)
    {
        $property = Properties::find($property_id);

        $dataset["data"] = [];
        $labels = [];

        foreach ($property->agregated_values  as $key => $item) {
            $dataset["data"][] += $item['value'];
            $labels[] = $item['created_at']->diffForHumans();
        }

        $propertyDetailChart = app()->chartjs
            ->name('propertyDetailChart')
            ->type('line')
            ->labels($labels)
            ->datasets([$dataset])
            ->optionsRaw("{
                scales: {
                    yAxes: [{
                        ticks: {
                            min: Math.min.apply(this, " . json_encode($dataset["data"]) . ") - 5,
                            max: Math.max.apply(this, " . json_encode($dataset["data"]) . ") + 5
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

        return view('controls.edit', compact('property', 'propertyForm'));
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
        $property->save();

        return redirect()->route('controls.edit', ['property_id' => $property_id]);
    }

    public function remove($property_id)
    {
        $property = Properties::find($property_id);
        $property->delete();

        return redirect()->route('controls.room');
    }
}
