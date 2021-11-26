<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automations extends Model
{
    public $incrementing = true;
    protected $table = 'sh_automations';
    protected $primaryKey = 'id';
    protected $dates = ['run_at'];

    use HasFactory;

    //ATTRIBUTES
    public function setConditionsAttribute($value)
    {
        $this->attributes['conditions'] = json_encode($value);
    }

    public function setActionsAttribute($value)
    {
        $this->attributes['actions'] = json_encode($value);
    }

    public function getConditionsAttribute($value)
    {
        return json_decode($value);
    }

    public function getActionsAttribute($value)
    {
        return json_decode($value);
    }

    //FUNCTIONS [ACTIONS]
    public function run($waiting = true)
    {
        $run = false;
        $restart = false;
        $error = false;

        if ($this->conditions != "manual") {
            foreach ($this->conditions as $key => $value) {
                # code...
            }
        } else {
            $run = true;
            $restart = true;
        }

        //TODO: hiest sleep time from all devices based on thies properties
        $waitTime = 1000000;

        $recordsIds = [];
        if ($this->actions != null && $run) {
            foreach ($this->actions as $propertyId => $propertyCommand) {
                $record                 = new Records;
                $record->origin         = "automation";
                $record->value          = $propertyCommand->value;
                $record->property_id    = $propertyId;
                $record->save();

                $recordsIds[] = $record->id;
            }
        }

        if ($waiting) {
            $timeout = 50;
            while (count($recordsIds) > 0 & $timeout > 0) {
                foreach ($recordsIds as $key => $value) {
                    $pendingRecord = Records::find($value);
                    if ($pendingRecord->done == 1) {
                        unset($recordsIds[$key]);
                    }
                }

                usleep($waitTime);
                $timeout--;
            }

            if ($timeout <= 0) {
                return false;
            }
        }

        return true;
    }
}
