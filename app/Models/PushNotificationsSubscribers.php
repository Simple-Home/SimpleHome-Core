<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotificationsSubscribers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'type',
    ];
    protected $table = 'sh_push_notifications_subscribers';
    protected $primaryKey = 'id';
}
