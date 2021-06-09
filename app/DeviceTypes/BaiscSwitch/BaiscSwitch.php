<?php

namespace App\DeviceTypes\BaiscSwitch;
use App\DeviceTypes\DeviceTypes;

abstract class BaiscSwitch extends DeviceTypes
{
    abstract public function on();
    abstract public function off();
}


?>
