<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForFirebase ($notifiable) {
        return $this->pushNotificationSubscription->pluck('token')->toArray();
    }

    public function locator()
    {
        return $this->hasOne('App\Models\Properties', 'id', "locator_id");
    }

    public function getGavatarUrl(){
        return 'https://secure.gravatar.com/avatar/'.md5($this->email);
    }

     public function pushNotificationSubscription()
    {
        return $this->hasMany('App\Models\PushNotificationsSubscribers', 'recipient_id');
    }
}
