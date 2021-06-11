<?php
namespace App\PropertyTypes\Sensor;

use App\PropertyTypes\PropertyTypes;

/**
 * Class Sensor
 * @package App\PropertyTypes\Sensor
 */
abstract class Sensor extends PropertyTypes
{
    private $sensor;
    abstract public function state($value);
    public function allowedValues(){ 
        return ["state"=>["*"]]; 
    }
}

?>