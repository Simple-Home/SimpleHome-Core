<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function read($notification_id)
    {
        Auth::user()->unreadNotifications->where('id', $notification_id)->markAsRead();
        return redirect()->back()->with('success', 'Notification mark as read');
    }

    public function delete($notification_id)
    {
        Auth::user()->notifications
            ->where('id', $notification_id) // and/or ->where('type', $notificationType)
            ->first()
            ->delete();
        return redirect()->back()->with('success', 'Notification removed');
    }
}
