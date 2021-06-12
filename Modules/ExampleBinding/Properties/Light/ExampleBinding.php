<?php
namespace Modules\ExampleBinding\Properties\Light;

use App\PropertyTypes\Light\Light;

/**
 * Class Example
 * @package App\PropertyTypes\Light
 */
class ExampleBinding extends Light
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
    public function state($value, $args){ 
        //This is where you control the light

        //This is how you notify Simple Home of the state chagne
        $this->setState('state', $value);
        $this->setState('brightness', $args['brightness']);
    }

    //API (GET): http://localhost/api/v2/property/(hostname)/brightness/(value)
    public function brightness($value){  
        //To just control the brightness use this

        //Brightness control code here
        $this->setState('brightness', $value);
    }

    //API (GET): http://localhost/api/v2/property/(hostname)/color/(value)
    public function color($value){
        //To just control the color use this

        //Color control code here
        $this->setState('color', $value);
    }
    
    //API (GET): http://localhost/api/v2/property/(hostname)/effect/(value)
    public function effect($value){
        //To just control the effect use this

        //Effect control code here
        $this->setState('effect', $value);
    }

    //API (GET): http://localhost/api/v2/property/(hostname)/colorTemp/(value)
    public function colorTemp($value){
        //To just control the colorTemp use this

        //ColorTemp control code here
        $this->setState('colorTemp', $value);
    }
}
