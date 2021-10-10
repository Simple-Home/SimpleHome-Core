<?php

namespace App\Helpers;

use Exception;
use App\Models\Settings;


class SettingManager
{
    public static function get($index, $group = null)
    {
        $fields = Settings::where('group', '=', $group)->where('name', '=', $index)->get();
        if (count($fields) >= 1) {
            return $fields->first();
        } else {
            SettingManager::set($index, 0, "string", $group);
            return Settings::where('group', '=', $group)->where('name', '=', $index)->first();
        }
    }

    public static function set($index, $value, $group = null)
    {
        $option =  Settings::where('group', '=', $group)->where('name', '=', $index)->first();

        // Make sure you've got the Page model
        if ($option) {
            $option->value = $value;
            $option->group = $group;
            $option->save();
        } else {
            SettingManager::register($index, $value, "string", "system");
        }

        return true;
    }

    public static function register($index, $value, $type = "string", $group = "system")
    {
        $option = Settings::firstOrCreate(
            [
                'group' => $group,
                'name' => $index,
                'type' => $type,
                'value' => $value,
            ]
        );
        return true;
    }

    public static function getGroup($group)
    {
        $found_indexes = Settings::where('group', '=', $group)->get();
        return $found_indexes;
    }
}
