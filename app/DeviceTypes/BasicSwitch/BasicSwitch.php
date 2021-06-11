<?php

namespace App\DeviceTypes\BasicSwitch;
use App\DeviceTypes\DeviceTypes;

abstract class BasicSwitch extends DeviceTypes
{
    abstract public function state($value);
    public function allowedValues(){ return array("state"=>array("ON","OFF")); }
}


?>
