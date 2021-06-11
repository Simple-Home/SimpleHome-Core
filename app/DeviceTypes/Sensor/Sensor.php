<?php

namespace App\DeviceTypes\Sensor;

use App\DeviceTypes\DeviceTypes;

/**
 * Class Sensor
 * @package App\DeviceTypes\Sensor
 */
abstract class Sensor extends DeviceTypes
{
    private $sensor;
    abstract public function state();
    public function allowedValues(){ return array("state"=>array("ON","OFF")); }
}

?>