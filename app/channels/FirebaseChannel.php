<?php

namespace App\Channels;

use App\Channels\LogChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class FirebaseChannel
{
    public function send ($notifiable, Notification $notification) {
        if (method_exists($notifiable, 'routeNotificationForLog')) {
            $id = $notifiable->routeNotificationForFirebase($notifiable);
        } else {
            $id = $notifiable->getKey();
        }

        $data = method_exists($notification, 'toLog')
            ? $notification->toLog($notifiable)
            : $notification->toArray($notifiable);
        if (empty($data)) {
            return;
        }

        return $this->sendToFirebase($data);
    }
    private function sendToFirebase($data){
         if (empty(env("FIREBASE_API_KEY"))) {
            return false;
        }

        $data = json_encode($data);
		$url = 'https://fcm.googleapis.com/fcm/send';
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key='. env("FIREBASE_API_KEY"),
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }
}