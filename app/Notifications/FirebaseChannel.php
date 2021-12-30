<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseChannel
{
    public function send($notifiable, Notification $notification)
    {


        if (!$recipients = $notifiable->pushNotificationSubscription->pluck('token')->toArray()) {
            return;
        }

        $message = $notification->toFirebase($notifiable);

        foreach ($recipients as $recipient) {
            $this->sendToFirebase($recipient, $message);
        }

        return true;
    }

    private function sendToFirebase($to, $data)
    {
        if (empty(env("FIREBASE_SERVER_KEY"))) {
            return false;
        }


        $dataPayload = json_encode([
            "to" => $to,
            //"data" => [],
            "notification" => $data,
        ]);
        Log::info($dataPayload);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Bearer ' . env("FIREBASE_SERVER_KEY"),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPayload);
        $result = curl_exec($ch);
        curl_close($ch);

        Log::info($result);
        $json = json_decode($result);

        if ($json->failure > 0) {
            Log::error($result);
        } else {
            Log::info($result);
        }

        return $result;
    }
}