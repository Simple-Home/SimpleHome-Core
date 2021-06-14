<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Devices;
use App\Models\Records;
use App\Models\Rooms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class Properties extends Model
{
    protected $fillable = [];
    protected $table = 'properties';

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
        return $this->hasMany(Records::class, 'property_id')->whereDate('created_at', '>', Carbon::now()->subDays(1))->orderBy('created_at', 'DESC');
    }

    public function getAgregatedValuesAttribute()
    {
        $format = 'Y-m-d H';
        $agregation = [];
        $result = [];
        $records = $this->values;
        foreach ($records as $key => $record) {
            $agregation[$record->created_at->format($format)][] = $record->value;
        }

        foreach ($agregation as $key => $groupedValues) {
            $result[] = [
                'value' => array_sum($groupedValues) / count($groupedValues),
                'created_at' => Carbon::createFromFormat($format,$key),
                'done' => '',
            ];
        }
        return $result;
    }

    public function last_value()
    {
        return $this->hasOne(Records::class, 'property_id', 'id')->orderBy('id', 'DESC');
    }

    use HasFactory;
}
