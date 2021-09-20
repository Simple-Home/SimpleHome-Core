<?php

namespace App\PropertyTypes\Toggle;
use App\PropertyTypes\PropertyTypes;

abstract class Toggle extends PropertyTypes
{
    abstract public function state($value);
    public function allowedValues(){ return array("state"=>array("on","off")); }
}


?>
