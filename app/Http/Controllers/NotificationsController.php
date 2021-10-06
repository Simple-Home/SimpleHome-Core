<?php

namespace App\Http\Controllers;

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
        if ($notification_id == "all") {
            foreach (Auth::user()->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        } else {
            Auth::user()->unreadNotifications->where('id', $notification_id)->markAsRead();
        }

        if ($request->ajax()) {
            $notifications = Auth::user()->notifications;
            return View::make("notifications.list")->with("notifications", $notifications)->render();
        }
        return redirect()->back()->with('success', 'Notification mark as read');
    }

    public function remove($notification_id, Request $request)
    {
        if ($notification_id == "all") {
            foreach (Auth::user()->notifications as $notification) {
                $notification->delete();
            }
        } else {
            Auth::user()->notifications->where('id', $notification_id)->first()->delete();
        }
        if ($request->ajax()) {
            $notifications = Auth::user()->notifications;
            return View::make("notifications.list")->with("notifications", $notifications)->render();
        }
        return redirect()->back()->with('success', 'Notification removed');
    }
}
