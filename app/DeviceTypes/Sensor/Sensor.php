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
    abstract public function battery();
    abstract public function values();
}

?>