<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Properties;

class DashboardController extends Controller
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
        $properties = Properties::all();
        $graphs = [];
        $rooms = [];
        $propertiesCount = [];

        foreach ($properties as $key => $property) {
            if (count($property->values) == 0) continue;
            $graphDataset = [];
            $graphDataset['data'] = [];
            $graphDataset['label'][] = $property->type;
            foreach ($property->values as $key => $value) {
                $graphDataset['data'][] = $value->value;
            }
            $graphs[$property->room->id][] = $this->getGraph($graphDataset);
            $rooms[$property->room->id] = $property->room->name;
            $propertiesCount[$property->room->id] = $property->room->properties_count;
        }
        return view('dashboard.dashboard', ["propertiesCount" => $propertiesCount, "graphs" => $graphs, "rooms" => $rooms]);
    }

    private function getGraph($dataset, $labels = [])
    {
        $graph = app()->chartjs
            ->name('propertyDetailChart' . rand(1, 999))
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
        return $graph;
    }
}
