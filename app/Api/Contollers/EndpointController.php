<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;

class EndpointController extends Controller
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

    public function date()
    {
        return view('dashboard');
    }

    public function ota()
    {
        return view('dashboard');
    }
}
