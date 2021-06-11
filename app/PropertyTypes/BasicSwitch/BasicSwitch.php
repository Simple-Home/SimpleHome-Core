<?php

namespace App\PropertyTypes\BasicSwitch;
use App\PropertyTypes\PropertyTypes;

abstract class BasicSwitch extends PropertyTypes
{
    abstract public function state($value);
    public function allowedValues(){ return array("state"=>array("on","off")); }
}


?>
