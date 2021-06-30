<?php

namespace App\Helpers;

use Exception;
use App\Models\Settings;


class SettingManager
{
    public static function get($index, $group = null) {
        $found_indexes = Settings::where('name', '=', $index)->first();
        if (!empty($found_indexes)) {
            return $found_indexes;
        } else {
            SettingManager::set($index, 0, $group);
            return Settings::where('name', '=', $index)->first();
        }
    }

    public static function set($index, $value, $group = "system") {
        $option =  Settings::where('name', '=', $index)->first();

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
        $found_indexes = Settings::where('group', '=', $group)->get();
        return $found_indexes;
    }
}
