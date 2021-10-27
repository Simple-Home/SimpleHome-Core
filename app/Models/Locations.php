<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\Log;

class Locations extends Model
{
    protected $table = 'sh_locations';
    use HasFactory;
}
