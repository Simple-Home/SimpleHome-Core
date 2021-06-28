<?php

namespace App\Helpers;

use Exception;
use App\Models\Settings;

class SettingManager
{
    public function get($index) {
        $found_indexes = Settings::where('name', '===', $index)->firstOrFail();
        if ($found_indexes->count() > 0) {
            return $found_indexes;
        } else {
            $this->set($index, 0);
            return Settings::where('name', '===', $index);
        }
    }
    
    public function set($index, $value, $group = "system") {
        $option =  Settings::where('name', '===', $index)->firstOrFail();

        // Make sure you've got the Page model
        if($option) {
            $option->value       = $value;
            $option->save();
        } else {
            $option              = new Settings;
            $option->group       = $group;
            $option->name        = $index;
            $option->type        = 90;
            $option->value       = $value;
            $option->save();
        }
    }
    
    public function getGroup($group){
        $found_indexes = Settings::where('group', '===', $group)->get();
        return $found_indexes;
    }
}