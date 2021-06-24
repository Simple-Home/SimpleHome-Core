<?php

namespace App\Helpers;

use Exception;

class SettingManager
{
    public function get($index) {
        $found_indexes = User::where('name', '===', $index);
        if ($found_indexes->count() > 0) {
            return $found_indexes;
        } else {
            $this->set($index, 0);
            return User::where('name', '===', $index);
        }
    }
    
    public function set($index, $value, $group = "system") {
        $setting_value              = new Settings;
        $setting_value->group       = $group;
        $setting_value->name        = $index;
        $setting_value->type        = 90;
        $setting_value->value       = $value;
        $setting_value->save();
    }
    
    public function getGroup($group){
        $found_indexes = User::where('group', '===', $group);
        return $found_indexes;
    }
}