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
}
