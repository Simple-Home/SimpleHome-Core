<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Rooms extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = false;
    protected $table = 'sh_rooms';

    protected $fillable = [
        'name',
    ];

    protected $attributes = [
        'default' => false,
    ];

    protected $appends = [
        'properties_count'
    ];


    public function getProperties()
    {
        return $this->hasMany('App\Models\Properties', 'room_id');
    }

    public function getPropertiesCountAttribute()
    {
        $properties = $this->getProperties();
        return $properties->count();
    }
}
