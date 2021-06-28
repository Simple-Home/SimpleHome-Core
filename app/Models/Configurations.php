<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configurations extends Model
{
    public $incrementing = true;
    protected $table = 'configurations';
    protected $fillable = [
        'configuration_key',
        'configuration_value',
    ];
    use HasFactory;
}
