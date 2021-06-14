<?php
namespace App\PropertyTypes\sensor;

use App\PropertyTypes\PropertyTypes;

/**
 * Class sensor
 * @package App\PropertyTypes\sensor
 */
abstract class sensor extends PropertyTypes
{
    private $sensor;
    abstract public function state($value);
    public function allowedValues(){ 
        return ["state"=>["*"]]; 
    }
}

?>