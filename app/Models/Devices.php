<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    protected $approved = [
        'Unapproved',
        'Approved',
        'Blocked',
    ];

    public function getProperties(){
        return $this->hasMany('App\Models\properties');
    }

    use HasFactory;
}
