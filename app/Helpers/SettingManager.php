<?php

namespace App\Helpers;

use Exception;
use App\Models\Settings;

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
        $option = Page::find($id);

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
        $found_indexes = User::where('group', '===', $group);
        return $found_indexes;
    }
}