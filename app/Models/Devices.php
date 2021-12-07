<?php

namespace App\Models;

use App\Notifications\DeviceRebootNotification;
use App\Notifications\NewDeviceNotification;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use app\Models\Properties;

class Devices extends Model
{
    /*
    protected $approved = [
        'Unapproved',
        'Approved',
        'Blocked',
    ];
    */

    protected $table = 'sh_devices';
    protected $dates = [
        'heartbeat'
    ];
    protected $casts = [
        'approved' => 'boolean',
    ];

    //ATTRIBUTES
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    //NEW
    public function getCommandAttribute($value)
    {
        $command = $value;

        if (empty($command) || $command === 'null')
            return $command;

        Log::info('Device Command Execution', ['id' => $this->id, 'command' => $command]);
        if ($command == "reset") {
            foreach (User::all() as $user) {
                $user->notify(new DeviceRebootNotification($this));
            }
        }

        $this->command = "null";
        $this->save();
        return $command;
    }

    public function executeCommand()
    {
        $command = $this->command;
        if (empty($command) || $command === 'null')
            return 'null';

        Log::info('Device Command Execution', ['id' => $this->id, 'command' => $command]);
        if ($command == "reset") {
            foreach (User::all() as $user) {
                //$user->notify(new DeviceRebootNotification($this));
            }
        }

        $this->command = "null";
        $this->save();
        return $command;
    }

    public function properties()
    {
        return $this->hasMany('App\Models\Properties', 'device_id');
    }


    //OLD
    public function getPropertiesExistence($type)
    {
        $property = $this->getProperties()->where('type', $type)->first();
        if (isset($property->type) && $property->type == $type) {
            return true;
        }
        return false;
    }

    public function getProperties()
    {
        return $this->hasMany('App\Models\Properties', 'device_id');
    }

    public function setHeartbeat()
    {
        $this->heartbeat = new DateTime();
        $this->save();
    }

    /**
     * check if device if offline
     *
     * @return bool
     */

    public function getOfflineAttribute()
    {
        $offline = false;

        $heartbeat = new DateTime($this->heartbeat);
        $sleep = empty($this->sleep) ? 1000 : $this->sleep;

        $heartbeat->modify("+" . $sleep . " ms");
        $heartbeat->modify("+10 seconds");

        $now = new DateTime();
        if ($heartbeat->getTimestamp() < $now->getTimestamp()) {
            $offline = true;
        }
        return $offline;
    }

    public function getHostname()
    {
        return str_replace(" ", "_", strtolower($this->hostname));
    }

    public function getIntegrationAttribute($value)
    {
        return strtolower($value);
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
        $RSSI = ($this->getProperties->where('type', 'wifi')->first());
        if ($RSSI && !empty($RSSI->latestRecord)) {
            return $RSSI->latestRecord->value;
        }

        return false;
    }

    public function getSignalStrengthPercentAttribute()
    {
        $RSSI = ($this->getProperties->where('type', 'wifi')->first());
        if ($RSSI && !empty($RSSI->latestRecord)) {
            // dBm to Quality:
            if ($RSSI->latestRecord->value <= -100) {
                return 0;
            } else if ($RSSI->latestRecord->value >= -50) {
                return ($RSSI->latestRecord->value = 100);
            } else {
                return (2 * ($RSSI->latestRecord->value + 100));
            }
        }

        return false;
    }

    public function getBatteryLevelAttribute()
    {
        $batteryVoltage = $this->getProperties->where('type', 'battery')->first();
        if (isset($batteryVoltage->latestRecord)) {
            return $batteryVoltage->latestRecord->value;
        }
        return false;
    }

    public function getBatteryLevelPercentAttribute()
    {
        $batteryVoltage = ($this->getProperties->where('type', 'battery')->first());
        if ($batteryVoltage && isset($batteryVoltage->latestRecord)) {
            $max = $batteryVoltage->max_value;
            $min = $batteryVoltage->min_value;
            $max = ($max - $min);

            $onePercent = $max / 100;
            if ($onePercent <= 0) {
                return false;
            }
            return ($batteryVoltage->latestRecord->value - $min) / $onePercent;
        }

        return false;
    }

    public function getSettingsCountAttribute()
    {
        $settings = Settings::where('group', '=', 'device-' . $this->id)->get();
        if ($settings) {
            return $settings->count();
        }
        return false;
    }

    public function reboot()
    {
        $this->command = "reset";
        $this->save();
    }

    public function approve()
    {
        $this->approved = "1";
        $this->save();
    }

    public function disapprove()
    {
        $this->approved = "0";
        $this->save();
    }

    public function save(array $options = [])
    {
        $result = parent::save($options);

        if (empty($this->id)) {
            foreach (User::all() as $user) {
                $user->notify(new NewDeviceNotification($this));
            }
        }

        return $result;
    }

    use HasFactory;
}
