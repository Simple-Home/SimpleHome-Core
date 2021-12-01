<?php

namespace App\Models;

use App\Models\Properties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automations extends Model
{
    public $incrementing = true;
    protected $table = 'sh_automations';
    protected $primaryKey = 'id';
    protected $dates = ['run_at'];
    protected $casts = [
        'is_locked' => 'boolean',
        'is_runed' => 'boolean',
        'is_enabled' => 'boolean',
    ];

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
        if ($this->is_locked) {
            return false;
        }
        $this->is_locked = true;
        $this->Save();

        if (empty($this->actions)) {
            $this->is_locked = false;
            $this->Save();
            return false;
        }

        $run = false;
        $restart = false;
        $error = false;

        if (!empty($this->conditions)) {
            foreach ($this->conditions as $key => $trigger) {

                $propertyInQuestion = Properties::find($key);
                $conditionValueActual = "";
                if (!call_user_func($propertyInQuestion->type, $conditionValueActual, $propertyInQuestion, $trigger)) {
                    $conditionValueActual = $propertyInQuestion->latestRecord->value;
                }

                $run = compare($trigger->operator, $conditionValueActual, $trigger->value);

                $restart = true;
            }
        } else {
            $run = true;
            $restart = true;
        }
        //TODO: highest sleep time from all devices based on those properties
        $waitTime = 2000;

        $recordsIds = [];

        if ($run) {
            //TODO: Add notification on running the notification
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

        $this->is_locked = false;
        $this->Save();
        return true;
    }

    public function compare($condition, $a, $b)
    {
        switch ($condition) {
            case '<':
                return $a < $b;
            case '>':
                return $a > $b;
            case '!=':
                return $a != $b;
            default:
                return $a == $b;
        }
    }

    private function location(&$value, $model, $trigger)
    {
        $value = ($model->getLocation() ? $model->getLocation()->id : null);
    }

    private function sun(&$value, $model, $trigger)
    {
        //
    }
}
