<?php
namespace Modules\ExampleBinding\Properties\BasicSwitch;

use App\PropertyTypes\BasicSwitch\BasicSwitch;

/**
 * Class Example
 * @package App\PropertyTypes\BasicSwitch
 */
class ExampleBinding extends BasicSwitch
{
    public $supportedAttributes = ["wifi","battery","uptime", "model"];

    public function __construct($meta){
        $this->meta = $meta;
        $this->features = $this->getFeatures($this);

        //Set property properties, these can be anything!
        $this->setAttributes('s/n', "DMRM36078");
        $this->setAttributes('model', "MX250");
    }

    //API (GET): http://localhost/api/v2/property/(hostname)/state/(value)?brightness=10&color=red
    public function state($value){ 
        //This is where you control the light

        //This is how you notify Simple Home of the state chagne
        $this->setState('state', $value);
    }
}
