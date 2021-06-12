<?php

namespace App\PropertyTypes\toggle;
use App\PropertyTypes\PropertyTypes;

abstract class toggle extends PropertyTypes
{
    abstract public function state($value);
    public function allowedValues(){ return array("state"=>array("on","off")); }
}


?>
