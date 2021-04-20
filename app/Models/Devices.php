<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Properties;

class Devices extends Model
{
    protected $approved = [
        'Unapproved',
        'Approved',
        'Blocked',
    ];

    public function getProperties(){
        return $this->hasMany('App\Models\Properties', 'device_id');
    }

    use HasFactory;
}
