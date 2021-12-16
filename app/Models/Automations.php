<?php

namespace App\Models;

use App\Models\Properties;
use App\Notifications\AutomationsRanNotification;
use Carbon\Carbon;
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
        'is_notified' => 'boolean',
    ];

    use HasFactory;

    //ATTRIBUTES
    public function setConditionsAttribute($value)
    {
        $this->attributes['conditions'] = null;
        if ($value != null)
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

        $this->run_at = Carbon::now();
        $this->is_locked = true;
        $this->Save();

        if (empty($this->actions)) {
            $this->is_locked = false;
            $this->Save();
            return false;
        }

        $outcome = [];

        $run = false;
        $restart = false;

        if (!empty($this->conditions)) {
            foreach ($this->conditions as $key => $trigger) {

                $propertyInQuestion = Properties::find($key);
                $conditionValueActual = "";

                if (method_exists($this, $propertyInQuestion->type)) {
                    $methodName = $propertyInQuestion->type;
                    $conditionValueActual =  $this->$methodName($propertyInQuestion, $trigger);
                } else {
                    $conditionValueActual = $propertyInQuestion->latestRecord->value;
                }

                $outcome[] = $this->compare($trigger->operator, $conditionValueActual, $trigger->value);
            }

            $outcomeCounts = array_count_values(
                array_map(function ($a) {
                    return ($a ? "true" : "false");
                }, $outcome)
            );

            if (!isset($outcomeCounts['false'])) {
                $run = true;
            } elseif (!isset($outcomeCounts['true'])) {
                $restart = true;
            }
        } else {
            $run = true;
            $restart = true;
        }

        if ($run && $this->is_runed == false) {
            //TODO: highest sleep time from all devices based on those properties
            $waitTime = 200000;
            $recordsIds = [];

            foreach ($this->actions as $propertyId => $propertyCommand) {
                $record                 = new Records;
                $record->origin         = "automation";
                $record->value          = $propertyCommand->value;
                $record->property_id    = $propertyId;
                $record->save();

                $recordsIds[] = $record->id;
            }

            if ($this->is_notified) {
                foreach (User::all() as $user) {
                    $user->notify(new AutomationsRanNotification($this));
                }
            }

            $this->is_runed = true;

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
                    $this->is_locked = false;
                    $this->Save();
                    return false;
                }
            }
        } elseif ($restart) {
            $this->is_runed = false;
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

    private function location($model, $trigger)
    {
        return ($model->getLocation() ? $model->getLocation()->id : null);
    }

    private function sun(&$value, $model, $trigger)
    {
        //
    }
}
