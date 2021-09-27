<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;



class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list()
    {
        return view('system.users.list', ["users" => User::all()]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        echo "Test";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, FormBuilder $formBuilder)
    {
        $user = Auth::user();
        $profileInformationForm = $formBuilder->create(\App\Forms\ProfileInformationForm::class, [
            'model' => $user,
            'method' => 'POST',
            'url' => route('user.update', ['user' => $user])
        ]);
        $settingForm = $formBuilder->create(\App\Forms\SettingForm::class, [
            'method' => 'POST',
            'url' => route('user.setting', ['user' => $user])
        ]);
        $changePasswordForm = $formBuilder->create(\App\Forms\ChangePasswordForm::class, [
            'method' => 'POST',
            'url' => route('user.changePassword', ['user' => $user])
        ]);
        $deleteProfileForm = $formBuilder->create(\App\Forms\DeleteProfileForm::class, [
            'method' => 'POST',
            'url' => route('user.verifyDelete', ['user' => $user])
        ]);
        $realyDeleteProfileForm = $formBuilder->create(\App\Forms\RealyDeleteProfileForm::class, [
            'method' => 'POST',
            'url' => route('user.delete', ['user' => $user])
        ]);



        return view('system.profile.detail', ['user' => $user] + compact('profileInformationForm', 'settingForm', 'changePasswordForm', 'deleteProfileForm', 'realyDeleteProfileForm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\ProfileInformationForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = $request->user();

        $user->name = $request->input('name');

        $user->save();
        return redirect()->route('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function setting(Request $request, User $user, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\SettingForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = $request->user();

        $user->language = $request->input('language');

        $user->save();
        return redirect()->route('system.user.profile', ['#settings'])->with('success', __('web.settingsSaved'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, User $user, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\ChangePasswordForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = $request->user();

        if (Hash::check($request->input('oldPassword'), $user->password)) {
            if ($request->input('newPassword') == $request->input('confirmPassword')) {
                $user->password = Hash::make($request->input('newPassword'));
            } else {
                return redirect()->back()
                    ->withErrors(['confirmPassword' => ["New password is not same as confirm Password!"]])
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->withErrors(['oldPassword' => ["Old password is wrong!"]])
                ->withInput();
        }

        $user->save();
        return redirect()->route('system.user.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function verifyDelete(Request $request, User $user)
    {
        $this->middleware('auth:sanctum');
        return redirect()->back()
            ->with(['verifyDelete' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function api(Request $request, User $user)
    {
        $user = $request->user();
        return view('users.api', ["user" => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, User $user)
    {
        $user = Auth::user();
        $request->session()->invalidate();
        $user->delete();
        $request->session()->flush();
        return redirect()->route('system.user.profile');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();

        return view('system.users.list', ["users" => $users]);
    }
}
