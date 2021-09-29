<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\Devices;
use App\Models\Records;
use App\Models\Rooms;

use App\Helpers\SettingManager;
use App\Types\GraphPeriod;
use App\Types\PropertyType;

class Properties extends Model
{
    protected $fillable = [];
    protected $table = 'sh_properties';
    protected $primaryKey = 'id';

    public $period = GraphPeriod::DAY;

    //OVERIDES
    // public function newFromBuilder($attributes = [], $connection = null)
    // {
    //     $class = "\\App\\Models\\" . ucfirst($attributes->type);

    //     if (class_exists($class)) {
    //         $model = new $class();
    //     } else {
    //         $model = $this->newInstance([], true);
    //     }

    //     $model = $this->newInstance([], true);

    //     $model->setRawAttributes((array)$attributes, true);
    //     $model->setConnection($connection ?: $this->getConnectionName());
    //     $model->fireModelEvent('retrieved', false);

    //     return $model;
    // }

    //REDECLARATION FOR USE IN SUBMODELS
    public function save(array $options = [])
    {
        return parent::save($options);
    }

    //NEW RELATIONS
    public function records()
    {
        return $this->hasMany(Records::class, 'property_id');
    }

    public function latestRecord()
    {
        return $this->hasOne(Records::class, 'property_id')->latestOfMany();
    }

    public function device()
    {
        return $this->belongsTo(Devices::class);
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

    public function settings()
    {
        if ($settings = SettingManager::getGroup('property-' . $this->id)) {
            return $settings;
        }
        return false;
    }

    //FUNCTIONS
    public function getLatestRecordNotNull()
    {
        return Records::where("property_id", $this->id)->where("value", "!=", null)->where("value", "!=", 0)->first();
    }

    //Virtual  Values
    use HasFactory;


    //Add Function for mutator for vaue (vith units) and rav value















    public function values()
    {
        $dateFrom = Carbon::now()->subDays(1);

        switch ($this->period) {
            case GraphPeriod::WEEK:
                $dateFrom = Carbon::now()->subWeek(1);
                break;
            case GraphPeriod::MONTH:
                $dateFrom = Carbon::now()->subMonth(1);
                break;
            case GraphPeriod::YEAR:
                $dateFrom = Carbon::now()->subYear(1);
                break;
        }

        return $this->hasMany(Records::class, 'property_id')->whereDate('created_at', '>', $dateFrom)->orderBy('created_at', 'DESC');
    }

    public function getAgregatedValuesAttribute($period = GraphPeriod::DAY)
    {
        $dateFrom = Carbon::now()->subDays(1);
        $periodFormat = "%Y-%m-%d %hh";

        switch ($this->period) {
            case GraphPeriod::WEEK:
                $dateFrom = Carbon::now()->subWeek(1);
                $periodFormat = "%Y-%m-%d";
                break;
            case GraphPeriod::MONTH:
                $dateFrom = Carbon::now()->subMonth(1);
                $periodFormat = "%Y-%m-%d";
                break;
            case GraphPeriod::YEAR:
                $dateFrom = Carbon::now()->subYear(1);
                $periodFormat = "%Y-%m";
                break;
        }

        $agregatedData = Records::select(['value', 'done', 'created_at'])
            ->selectRaw("DATE_FORMAT(created_at, ?) as period", [$periodFormat])
            ->selectRaw("ROUND(MIN(value), 1) AS min")
            ->selectRaw("ROUND(MAX(value), 1) AS max")
            ->selectRaw("ROUND(AVG(value), 1) AS value")
            ->where('property_id', $this->id)
            ->orderBy('created_at', 'DESC')
            ->groupBy('period');

        $agregatedData->where('created_at', '>=', $dateFrom);
        return $agregatedData->get();
    }

    public function last_value()
    {
        return $this->hasOne(Records::class, 'property_id', 'id')->latest();
    }




    //Virtual  Values


    //Virtual  Values
    /**
     * Minimum value that property had in past.
     *
     * @return int
     */
    public function getMaxValueAttribute()
    {
        if ($this->records) {
            return $this->records->max("value");
        }
        return false;
    }

    /**
     * Maximum value that property had in past.
     *
     * @return int
     */
    public function getMinValueAttribute()
    {
        if ($this->records) {
            return $this->records->min("value");
        }
        return false;
    }


    /**
     * step value used to increment each value usualy used for range type or termostats, graphs also.
     *
     * @return int
     */
    public function getStepValueAttribute()
    {
        if ($step = SettingManager::get('step', 'property-' . $this->id)) {
            return ($step->value < 1 ? $step->value : 1);
        }
        return false;
    }

    /**
     * max set value for prop
     *
     * @return int
     */
    public function getMaxValueSettingAttribute()
    {
        if ($step = SettingManager::get('max', 'property-' . $this->id)) {
            return ($step->value > 1 ? $step->value : 1);
        }
        return false;
    }

    /**
     * min set value for prop
     *
     * @return int
     */
    public function getMinValueSettingAttribute()
    {
        if ($step = SettingManager::get('min', 'property-' . $this->id)) {
            return ($step->value > 1 ? $step->value : 1);
        }
        return false;
    }


    public function setValue($value)
    {
        $record                 = new Records;
        $record->value          = $value;
        $record->property_id    = $this->id;
        $record->save();
        return true;
    }
}
