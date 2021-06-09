<?php

namespace App\DeviceTypes\Light;


use App\DeviceTypes\DeviceTypes;

/**
 * Class Light
 * @package App\DeviceTypes\Light
 */
abstract class Light extends DeviceTypes
{
    abstract public function state();
    abstract public function brightness();
    abstract public function color();
    abstract public function colorTemp();
    abstract public function effect();
}