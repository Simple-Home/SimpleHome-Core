<?php

namespace App\DeviceTypes;

/**
 * Class DeviceTypes
 * @package App\DeviceTypes
 */
abstract class DeviceTypes
{
    protected $deviceTypes;
    protected $meta;
    public $features;
    private $status = array();

    /**
     * getFeatures
     * Get all supported features and return as array
     * 
     * @param mixed $classObject
     * @return void
     */
    public function getFeatures($classObject)
    {
        $class = new \ReflectionClass(get_class($classObject)); // Create Reflection Object
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC); // Retrieve all public methods
        $features = array();

        if(sizeof($methods) > 0){ // If > 0 features have been found
            for($i = 0; $i < sizeof($methods); ++$i){
                if ($methods[$i]->name != 'getFeatures' && $methods[$i]->name != '__construct') {
                    $features[$i]['name'] = $methods[$i]->name;
                }
            }
        }
        return $features;
    }


    /**
     * hasFeature
     * Check if an device has the requested feature
     * 
     * @param mixed $classObject
     * @param mixed $feature
     * @return void
     */
    public function hasFeature($classObject, $feature)
    {
        $features = $this->getFeatures($classObject);

        foreach($features as $c){
            if (strtolower($c['name']) == strtolower($feature)) {
                return true;
            }
        }
        return false;
    }

    
    /**
     * getStatus
     * 
     * @param mixed feature
     * @return void
     */
    public function getStatus($feature = null)
    {   
        return ($feature!=null ? $this->status[$feature] : $this->status );
    }

    /**
     * setStatus
     * 
     * @param mixed feature
     * @param mixed status
     * @return void
     */
    public function setStatus($feature, $status)
    {
        $this->status[$feature] = $status;
    }

}