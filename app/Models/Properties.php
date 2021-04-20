<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Devices;
use App\Models\Records;
use Illuminate\Support\Facades\DB;


class Properties extends Model
{
    protected $fillable = [
    ];

    public function device(){
        return $this->belongsTo(Devices::class);
    }

    public function values(){
        return $this->hasMany(Records::class, 'property_id');
    }

    public function lastValue(){
        return $this->hasOne(Records::class, 'property_id')->latest('time');
    }

    use HasFactory;
}
