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

    //New Relations
    public function properties()
    {
        return $this->hasMany('App\Models\Properties', 'room_id');
    }

    public function getPropertiesCountAttribute()
    {
        return $this->properties()->count();
    }

    //New Functions 

    public function setDefault()
    {
        $rooms = Rooms::where('default', true)->get();
        foreach ($rooms as $key => $room) {
            $room->default = 0;
            $room->save();
        }
        $this->default = true;
        $this->save();
        return $this;
    }

    //OLD RELATIONS 
    public function getProperties()
    {
        return $this->hasMany('App\Models\Properties', 'room_id');
    }
    /**
     * check if device if offline
     *
     * @return array
     */

    public function getStateAttribute()
    {
        $roomStates = [];
        $propertyes = $this->getProperties;
        foreach ($propertyes as $property) {
            $roomStates[$property->type][] = $property->last_value->value;
        }

        foreach ($roomStates as $type => $roomState) {
            $roomStates[$type] = array_sum($roomStates[$type]) / count($roomStates[$type]);
        }

        return $roomStates;
    }
}
