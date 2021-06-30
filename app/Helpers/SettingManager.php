<?php

namespace App\Helpers;

use Exception;
use App\Models\Settings;


class SettingManager
{
    public static function get($index, $group = null) {
        $found_indexes = Settings::where('name', '=', $index)->firstOrFail();
        if ($found_indexes->count() > 0) {
            return $found_indexes;
        }

        self::set($index, 0, $group);
        return Settings::where('name', '=', $index);
    }
    
    public static function set($index, $value, $group = "system") {
        $option =  Settings::where('name', '=', $index)->firstOrFail();

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
    
    public static function getGroup($group){
        return Settings::where('group', '=', $group)->get();
    }
}