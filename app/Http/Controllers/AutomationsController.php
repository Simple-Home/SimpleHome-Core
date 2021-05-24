<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;


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
    public function list()
    {
        return view('automations.list', ["automations" => "test"]);
    }
}
