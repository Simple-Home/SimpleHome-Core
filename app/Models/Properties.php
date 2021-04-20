<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Devices;

class Properties extends Model
{
    protected $fillable = [
    ];

    public function device(){
        return $this->belongsTo(Devices::class);
    }

    public function add(){

    }

    use HasFactory;
}
