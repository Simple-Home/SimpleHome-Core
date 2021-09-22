<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['name', 'group', 'type', 'value'];
    protected $table = 'settings';
    protected $attributes = [
        'group' => 'system',
    ];
    //TODO: Make Migration
    use HasFactory;

    public function getValueAttribute($value)
    {
        $rawValue = $value;
        try {
            if (settype($value, $this->type)) {
                return $value;
            }
        } catch (\Throwable $th) {
            dd($this->type);
        }
        return $rawValue;
    }
}
