<?php

namespace App\PropertyType;

use App\Models\Properties;

class Temp extends Properties
{
    protected $historyDefault = 90;
    protected $unitsDefault = "C";
    protected $iconDefault = "";

    public function save(array $options = array())
    {
        if ($this->icon == "")
            $this->icon = $this->iconDefault;

        if ($this->history == 0)
            $this->history = $this->historyDefault;

        if ($this->units == "")
            $this->units = $this->unitsDefault;

        parent::save($options);
    }
}
