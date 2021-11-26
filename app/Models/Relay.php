<?php

namespace App\Models;

use App\Models\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Properties;

class Relay extends Properties
{
    protected $historyDefault = 90;
    protected $unitsDefault = "";
    protected $iconDefault = "fas fa-power-off";
    protected $graphSupport = false;

    public function getGraphSupport()
    {
        return $this->graphSupport;
    }


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
}
