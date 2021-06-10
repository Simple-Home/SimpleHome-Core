<?php

namespace App\DeviceTypes\BasicSwitch;
use App\DeviceTypes\DeviceTypes;

abstract class BasicSwitch extends DeviceTypes
{
    abstract public function state();
    abstract public function brightness();
}


?>
