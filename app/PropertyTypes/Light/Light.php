<?php

namespace App\PropertyTypes\Light;

use App\PropertyTypes\PropertyTypes;

/**
 * Class Light
 * @package App\PropertyTypes\Light
 */
abstract class Light extends PropertyTypes
{
    abstract public function state($value, $args);
    abstract public function brightness($value);
    abstract public function color($value);
    abstract public function colorTemp($value);
    abstract public function effect($value);
    public function allowedValues(){ 
        return [
                "state"=>["on","off"], 
                "brightness"=>["1","2","3","4","5","6","7","8","9","10"],
                "color"=>["*"],
                "colorTemp"=>["warm","cool"],
                "effect"=>["flash", "colorloop"],
                ];
    }
}