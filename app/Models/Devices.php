<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Properties;
use App\Helpers\SettingManager;
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
        $property = $this->getProperties()->where('type', $type)->first();
        if (isset($property->type) && $property->type == $type) {
            return true;
        }
        return false;
    }

    public function getHostname()
    {
        return str_replace(" ", "_", strtolower($this->hostname));
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getRateLimitAttribute()
    {
        $rate = 1000;
        if (!empty($this->sleep) && $this->sleep > 0) {
            $rate = (60 / ($this->sleep / 1000));
        }
        return $rate;
    }

    public function getSignalStrengthAttribute()
    {
        $RSSI = ($this->getProperties->where('type','==','wifi')->first());
        if ($RSSI){
            return (2 * ($RSSI->last_value->value + 100));
        }

        return false;
    }

    public function getBatteryLevelAttribute()
    {
        $BatteryValue = ($this->getProperties->where('type','==','batt')->first());
        if ($BatteryValue){
            return $BatteryValue->last_value->value;
        }
        return false;
    }

    public function getSettingsCountAttribute()
    {
        $settings = Settings::where('group', '=', 'device-'.$this->id)->get();
        if ($settings){
            return $settings->count();
        }
        return false;
    }

    use HasFactory;
}
