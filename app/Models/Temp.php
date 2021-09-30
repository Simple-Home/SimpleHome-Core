<?php

namespace App\Models;

use App\Models\Properties;

class Temp extends Properties
{
    protected $historyDefault = 90;
    protected $unitsDefault = "°C";
    protected $iconDefault = "fas fa-thermometer-empty";

    public function save(array $options = [])
    {
        $this->setDefaultValues();
        // before save code 
        $result = parent::save($options); // returns boolean
        // after save code
        return $result; // do not ignore it eloquent calculates this value and returns this, not just to ignore
    }

    public function update(array $attributes = [], array $options = [])
    {
        $this->setDefaultValues();
        // before save code 
        $result = parent::update($attributes, $options); // returns boolean
        // after save code
        return $result; // do not ignore it eloquent calculates this value and returns this, not just to ignore
    }

    private function setDefaultValues()
    {
        if ($this->icon == "" || $this->icon == "empty")
            $this->icon = $this->iconDefault;

        if ($this->history == 0)
            $this->history = $this->historyDefault;

        if ($this->units == "")
            $this->units = $this->unitsDefault;
    }

    public function getIconAttribute($value)
    {
        return $value;
    }
}
