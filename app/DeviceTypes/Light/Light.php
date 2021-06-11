<?php

namespace App\DeviceTypes\Light;


use App\DeviceTypes\DeviceTypes;

/**
 * Class Light
 * @package App\DeviceTypes\Light
 */
abstract class Light extends DeviceTypes
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
                "color"=>["red","green","blue","orange","yellow","purple","white"],
                "colorTemp"=>["warm","cool"],
                "effect"=>["flash", "colorloop"],
                ];
    }
}