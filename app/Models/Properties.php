<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Devices;
use App\Models\Records;
use App\Models\Rooms;
use Illuminate\Support\Carbon;
use App\Types\GraphPeriod;
use Illuminate\Support\Facades\DB;


class Properties extends Model
{
    protected $fillable = [];
    protected $table = 'sh_properties';
    public $period = GraphPeriod::DAY;

    public function device()
    {
        return $this->belongsTo(Devices::class);
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

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

    use HasFactory;
}
