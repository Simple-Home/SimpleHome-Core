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
        $roomsForm = [];
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

        return view('system.rooms.list', compact('roomForm', 'rooms', 'roomsForm'));
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

        foreach ($rooms as $room) {
            $roomsForm[$room->id] = $formBuilder->create(\App\Forms\RoomForm::class, [
                'model' => $room,
                'method' => 'POST',
                'url' => route('rooms.update', ['id' => $room->id]),
            ], ['edit' => true]);
        }

        return view('system.rooms.list', compact('roomForm', 'roomsForm', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
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

        return redirect()->route('system.rooms.list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
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

        return redirect()->route('system.rooms.list');
    }

    /**
     * @param int $roomId
     * @param int $default
     * @return \Illuminate\Http\RedirectResponse
     */
    public function default($room_id): \Illuminate\Http\RedirectResponse
    {
        $newDefaultRoom = Rooms::find($room_id)->setDefault();
        return redirect()->back()->with('success', 'Room ' . $newDefaultRoom->name . ' was made default.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function remove($room_id)
    {
        Rooms::find($room_id)->delete();
        return redirect()->back()->with('error', 'Room deleted!');
    }
}
