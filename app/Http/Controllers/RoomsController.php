<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

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
    public function list(FormBuilder $formBuilder)
    {
        $rooms = Rooms::all();
        $roomForm = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store'),
        ], ['edit' => false]);
        foreach ($rooms as $room) {
            $roomsForm[$room->id] = $formBuilder->create(\App\Forms\RoomForm::class, [
                'model' => $room,
                'method' => 'POST',
                'url' => route('rooms.update', ['id' => $room->id]),
            ], ['edit' => true]);
        }

        return view('rooms.list', compact('roomForm', 'rooms', 'roomsForm'));
    }

    public function search(Request $request, FormBuilder $formBuilder)
    {
        $search = $request->input('search');

        $rooms = Rooms::query()
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->get();
        
        $roomForm = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store'),
        ], ['edit' => false]);

        return view('rooms.list', compact('roomForm', 'rooms'));
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
        $form = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store'),
        ], ['edit' => false]);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $room = new Rooms();
        $room->name = $request->input('name');
        $room->save();

        return redirect()->route('rooms_list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\RoomForm::class, [
            'method' => 'POST',
            'url' => route('rooms.store', ['id' => $id]),
        ], ['edit' => true]);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $room = Rooms::where('id', $id)->first();
        $room->name = $request->input('name');
        $room->save();

        return redirect()->route('rooms_list');
    }

    public function default($roomId)
    {
        DB::table('rooms')->update(array('default' => 0));
        DB::table('rooms')->where('id', '=', $roomId)->update(array('default' => 1));
        return redirect()->route('rooms_list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rooms::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Room deleted!');
    }
}
