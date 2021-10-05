<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function read($notification_id)
    {
        if ($notification_id == "all") {
            foreach (Auth::user()->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        } else {
            Auth::user()->unreadNotifications->where('id', $notification_id)->markAsRead();
        }
        return redirect()->back()->with('success', 'Notification mark as read');
    }

    public function remove($notification_id)
    {
        if ($notification_id == "all") {
            foreach (Auth::user()->notifications as $notification) {
                $notification->delete();
            }
        } else {
            Auth::user()->notifications->where('id', $notification_id)->first()->delete();
        }

        return redirect()->back()->with('success', 'Notification removed');
    }
}
