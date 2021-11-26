<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Locations extends Model
{
    protected $table = 'sh_locations';
    use HasFactory;

    public function setPositionAttribute($value)
    {
        $this->attributes['POSITION'] = json_encode($value);
    }

    public function getPositionAttribute($value)
    {
        return json_decode($value);
    }
}
