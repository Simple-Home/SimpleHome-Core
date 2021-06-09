<?php

namespace App\DeviceTypes\Speaker;

use App\DeviceTypes\DeviceTypes;

/**
 * Class Speaker
 * @package App\DeviceTypes\Speaker
 */
abstract class Speaker extends DeviceTypes
{
    private $speaker;
    abstract public function power();
    abstract public function play();
    abstract public function pause();
    abstract public function forward();
    abstract public function reverse();
    abstract public function mute();
    abstract public function volume();
}

?>