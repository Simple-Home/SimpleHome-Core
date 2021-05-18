<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
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
        return view('rooms.list', ["rooms" => Rooms::all()]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $devices = Rooms::query()
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->get();

        return view('rooms.list', ["rooms" => $devices]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\ProfileInformationForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = $request->user();

        $user->name = $request->input('name');

        $user->save();
        return redirect()->route('rooms_list');
    }

    public function default($roomId)
    {
        DB::table('rooms')->update(array('default' => 0));
        DB::table('rooms')->where('id', '=', $roomId)->update(array('default' => 1));
        return redirect()->route('rooms_list');
    }
}
