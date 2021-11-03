<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Models\PushNotificationsSubscribers;



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
    public function list(FormBuilder $formBuilder)
    {
        $userForm = $formBuilder->create(\App\Forms\UserForm::class, [
            'method' => 'POST',
            'url' => route('system.users.storage')
        ]);

        return view('system.users.list', ["users" => User::all()] + compact('userForm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storage(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\UserForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'language' => "en",
        ]);

        return redirect()->route('system.users.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, FormBuilder $formBuilder)
    {
        $user = auth()->user();
        $profileInformationForm = $formBuilder->create(\App\Forms\ProfileInformationForm::class, [
            'model' => $user,
            'method' => 'POST',
            'url' => route('system.profile.update', ['user' => $user])
        ]);
        $notificationForm = $formBuilder->create(\App\Forms\NotificationForm::class, [
            'method' => 'POST',
            'url' => route('system.profile.notifications', ['user' => $user])
        ]);
        $settingForm = $formBuilder->create(\App\Forms\SettingForm::class, [
            'method' => 'POST',
            'url' => route('system.profile.setting', ['user' => $user])
        ]);
        $changePasswordForm = $formBuilder->create(\App\Forms\ChangePasswordForm::class, [
            'method' => 'POST',
            'url' => route('system.profile.changePassword', ['user' => $user])
        ]);
        $deleteProfileForm = $formBuilder->create(\App\Forms\DeleteProfileForm::class, [
            'method' => 'POST',
            'url' => route('system.profile.verifyDelete', ['user' => $user])
        ]);
        $realyDeleteProfileForm = $formBuilder->create(\App\Forms\RealyDeleteProfileForm::class, [
            'method' => 'POST',
            'url' => route('system.profile.delete', ['user' => $user])
        ]);

        return view('system.profile.detail', ['user' => $user] + compact('notificationForm', 'profileInformationForm', 'settingForm', 'changePasswordForm', 'deleteProfileForm', 'realyDeleteProfileForm'));
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
        return redirect()->route('system.profile');
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
        return redirect()->route('system.profile', ['#settings'])->with('success', __('web.settingsSaved'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function notifications(Request $request, User $user, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\NotificationForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $user = $request->user();
        $notifications = [];
        if (!empty($request->input('mail'))) {
            if ($notifications != "") {
                $notifications[] = 'mail';
            }
        }
         if (!empty($request->input('database'))) {
            if ($notifications != "") {
                $notifications[] = 'database';
            }
        }
         if (!empty($request->input('firebase'))) {
            if ($notifications != "") {
                $notifications[] = 'firebase';
            }
        }
        $user->notification_preferences = $notifications;
        $user->save();

        return redirect()->route('system.profile', ['#notifications'])->with('success', __('web.notificationsSaved'));
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
        return redirect()->route('system.profile');
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
    public function remove($user_id, Request $request)
    {
        $user = User::find($user_id);
        if ($user == auth()->user()) {
            $user->delete();
            $request->session()->invalidate();
            $request->session()->flush();
        } else {
            $user->delete();
        }
        return redirect()->route('system.users.list');
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

    //Ajax Calls
    public function userLocationsAjax(Request $request)
    {
        $locationSlug = "home";
        $usersLocators = User::where('locator_id', "!=", "")->get()->filter(function ($item) use ($locationSlug) {
                if ($item->locator->getLocation() !== false and $item->locator->getLocation()->name == $locationSlug) {
                    return $item;
                }
            });

        return View::make("components.locators")->with("usersLocators", $usersLocators)->render();
    }

    public function subscribe(Request $request){
        $user = auth()->user();
        $token = $request->token;
        
        $subscription = PushNotificationsSubscribers::where("recipient_id",$user->id)->where('token', $token)->first();
        if ($subscription != null){
            return true;
        }

        $subscriber = new PushNotificationsSubscribers();
        $subscriber->recipient_id = $user->id;
        $subscriber->token = $token;
        return $subscriber->save();
    }
}
