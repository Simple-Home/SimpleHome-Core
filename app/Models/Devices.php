<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Properties;
use DateTime;

class Devices extends Model
{
    protected $approved = [
        'Unapproved',
        'Approved',
        'Blocked',
    ];


    public function getProperties()
    {
        return $this->hasMany('App\Models\Properties', 'device_id');
    }

    public function setHeartbeat()
    {
        $this->heartbeat = new DateTime();
        $this->save();
    }

    public function getPropertiesExistence($type)
    {
        $property = $this->getProperties->where('type', $type)->first();
        if (isset($property->type) && $property->type == $type) {
            return true;
        }
        return false;
    }

    public function getHostname(){
        return str_replace(" ", "_", strtolower($this->hostname));
    }

    public function getAuthIdentifier(){
        return $this->getKey();
    }

    public function getRateLimitAttribute($value)
    {
        $rate = 1000;
        if (!empty($this->sleep) && $this->sleep > 0){
            $rate = (60 / ($this->sleep / 1000));
        }
        return $rate;
    }

    use HasFactory;
}
