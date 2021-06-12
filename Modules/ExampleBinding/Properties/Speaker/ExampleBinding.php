<?php
namespace Modules\ExampleBinding\Properties\Speaker;

use App\PropertyTypes\Speaker\Speaker;

/**
 * Class Example
 * @package App\PropertyTypes\Speaker
 */
class ExampleBinding extends Speaker
{
    public $supportedAttributes = ["wifi","battery","uptime", "model"];

    public function __construct($meta){
        $this->meta = $meta;
        $this->features = $this->getFeatures($this);

        //Set property properties, these can be anything!
        $this->setAttributes('s/n', "DMRM36078");
        $this->setAttributes('model', "MX250");
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/state/(value)?brightness=10&color=red
    public function state($value, $args){ 
        //This is where you control the light

        //This is how you notify Simple Home of the state chagne
        $this->setState('state', $value);
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/state/(value)?volume=10
    public function state($value, $args) {
        //This is where you control the speaker

        //This is how you notify Simple Home of the state chagne
        $this->setState('state', $value);
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/play/
    public function play() {
        //This is where you control the speaker

        //This is how you notify Simple Home of the state chagne
        $this->setState('playing', $value);
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/pause/
    public function pause() {
        //This is where you control the speaker

        //This is how you notify Simple Home of the state chagne
        $this->setState('playing', $value);
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/next/
    public function next() {
        //This is where you control the speaker
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/back/
    public function back() {
        //This is where you control the speaker
    }
    
    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/forward/
    public function forward() {
        //This is where you control the speaker
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/reverse/
    public function reverse() {
        //This is where you control the speaker
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/mute/(value)
    public function mute($value) {
        //This is where you control the speaker
    }

    //API (GET): http://localhost/api/v2/device/(hostname)/(property)/state/(value)
    public function volume($value) {
        //This is where you control the light
    }
}
