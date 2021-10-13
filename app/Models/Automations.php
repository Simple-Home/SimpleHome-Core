<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automations extends Model
{
    public $incrementing = true;
	protected $table = 'sh_automations';
	protected $primaryKey = 'id';
    protected $dates = ['run_at'];
    
	use HasFactory;

    public function setConditionsAttribute($value){
        $this->attributes['conditions'] = json_encode($value);
    }
    
    public function setActionsAttribute($value){
        $this->attributes['actions'] = json_encode($value);
    }

    public function getConditionsAttribute($value){
        return json_decode($value);
    }
    
    public function getActionsAttribute($value){
        return json_decode($value);
    }
}
