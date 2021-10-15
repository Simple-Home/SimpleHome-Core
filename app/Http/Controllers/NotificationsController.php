<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        $notifications = Auth::user()->notifications;
        return View::make("notifications.list")->with("notifications", $notifications)->render();
    }

    public function read($notification_id, Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($notification_id == "all") {
            foreach ($user->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        } else {
            $user->unreadNotifications->where('id', $notification_id)->markAsRead();
        }

        $user = User::find($user->id);
        if ($request->ajax()) {
            $notifications = User::find($user->id)->notifications;
            return View::make("notifications.list")->with("notifications", $notifications)->render();
        }
        return redirect()->back()->with('success', 'Notification mark as read');
    }

    public function remove($notification_id, Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($notification_id == "all") {
            foreach ($user->notifications as $notification) {
                $notification->delete();
            }
        } else {
            $user->notifications->find($notification_id)->delete();
        }

        $user = User::find(Auth::user()->id);
        if ($request->ajax()) {
            $notifications = $user->notifications;
            return View::make("notifications.list")->with("notifications", $notifications)->render();
        }
        return redirect()->back()->with('success', 'Notification removed');
    }

    
    public function countAjax()
    {
        $notificationsCount = Auth::user()->unreadNotifications->count();
        return $notificationsCount;
    }
}
