<?php

namespace App\DeviceTypes\Speaker;

use App\DeviceTypes\DeviceTypes;

/**
 * Class Speaker
 * @package App\DeviceTypes\Speaker
 */
abstract class Speaker extends DeviceTypes
{
    private $speaker;
    abstract public function state();
    abstract public function play();
    abstract public function pause();
    abstract public function forward();
    abstract public function reverse();
    abstract public function mute();
    abstract public function volume();
    public function allowedValues(){ 
        return [
                "state"=>["on","off"], 
                "play"=>[],
                "pause"=>[],
                "forward"=>[],
                "reverse"=>[],
                "mute"=>["on", "off"],
                "volume"=>["1","2","3","4","5","6","7","8","9","10"],
                ];
}

?>