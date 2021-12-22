<?php

namespace App\Models;

use App\Helpers\SettingManager;
use App\Models\Devices;
use App\Models\Records;
use App\Models\Rooms;

use App\Types\DeviceTypes;
use App\Types\GraphPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Properties extends Model
{


    protected $fillable = [
        'id',
        'units',
        'nickname',
        'type',
    ];
    protected $table = 'sh_properties';
    protected $primaryKey = 'id';

    public $period = GraphPeriod::DAY;

    protected $casts = [
        'is_disabled' => 'boolean',
        'is_hidden' => 'boolean',
    ];

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

    //OVERRIDES
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $class = "\\App\\Models\\" . ucfirst($attributes->type);

        if (class_exists($class)) {
            $model = new $class();
            // Important
            $model->exists = true;
            $model->setTable($this->getTable());
            $model->mergeCasts($this->casts);
        } else {
            $model = $this->newInstance([], true);
        }

        $model->setRawAttributes((array)$attributes, true);
        $model->setConnection($connection ?: $this->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    //Virtual  Values
    use HasFactory;

    //Add Function for mutator for value (with units) and rav value
    public function getNiceValueAttribute()
    {
        return $this->value . " " . $this->units;
    }

    public function getMaxSettingValueAttribute()
    {

        if ($max = SettingManager::get('max', 'property-' . $this->id)) {
            return $max->value;
        }
        return 10;
    }

    public function getMinSettingValueAttribute()
    {
        if ($min = SettingManager::get('min', 'property-' . $this->id)) {
            return $min->value;
        }
        return 1;
    }

    /**
     * step value used to increment each value usually used for range type or thermostats, graphs also.
     *
     * @return int
     */
    public function getStepSettingValueAttribute()
    {
        if ($step = SettingManager::get('step', 'property-' . $this->id)) {
            return ($step->value < 1 ? $step->value : 1);
        }
        return 5;
    }

    //OLD
    public function values()
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

        return $this->hasMany(Records::class, 'property_id')->whereDate('created_at', '>=', $dateFrom)->orderBy('created_at', 'DESC');
    }

    public function getAgregatedValuesAttribute()
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

    //Virtual  Values
    /**
     * Minimum value that property had in past.
     *
     * @return int
     */
    public function getMaxValueAttribute()
    {
        if ($this->records) {
            return Cache::remember('property-' . $this->id . '-max', 1800, function () {
                return $this->records->max("value");
            });
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
            return Cache::remember('property-' . $this->id . '-min', 1800, function () {
                return $this->records->min("value");
            });
        }
        return false;
    }

    public function setValue($value, $origin = null)
    {
        $record                 = new Records;
        $record->value          = $value;
        $record->property_id    = $this->id;

        if ($origin != null) {
            $record->origin    = $origin;
        }

        $record->save();
        return true;
    }

    public function hide()
    {
        $this->is_hidden = true;
        $this->save();
        return true;
    }

    public function show()
    {
        $this->is_hidden = false;
        $this->save();
        return true;
    }

    public function enable()
    {
        $this->is_enabled = true;
        $this->save();
        return true;
    }

    public function disable()
    {
        $this->is_enabled = false;
        $this->save();
        return true;
    }
}
