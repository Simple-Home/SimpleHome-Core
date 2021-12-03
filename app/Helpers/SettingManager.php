<?php

namespace App\Helpers;

use App\Models\Settings;
use Exception;
use Illuminate\Support\Facades\Cache;


class SettingManager
{
    public static function get($index, $group = null)
    {
        $option = Cache::remember('settings', 15, function () use ($index, $group) {
            $option =  Settings::where('name', '=', $index);
            if ($group != null) {
                $option = $option->where('group', '=', $group);
            }
            return $option->get();
        });

        if (count($option) >= 1) {
            return $option->first();
        } else {
            SettingManager::set($index, 0, "string", $group);
            return Settings::where('group', '=', $group)->where('name', '=', $index)->first();
        }
    }

    public static function set($index, $value, $group = null)
    {
        $option =  Settings::where('name', '=', $index);
        if ($group != null) {
            $option = $option->where('group', '=', $group);
        }
        $option = $option->first();

        // Make sure you've got the Page model
        if ($option) {
            $option->value = $value;
            if ($group != null) {
                $option->group = $group;
            }
        } else {
            SettingManager::register($index, $value, "string", "system");
        }
        Cache::forget('settings');
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
        Cache::forget('settings');
        return true;
    }

    public static function getGroup($group)
    {
        $found_indexes = Settings::where('group', '=', $group)->get();
        Cache::forget('settings');
        return $found_indexes;
    }
}
