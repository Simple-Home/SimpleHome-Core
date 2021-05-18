<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    public $incrementing = false;
    protected $table = 'records';
    protected $primaryKey = 'id';
    public $fillable = [
        "value",
        "done",
    ];
    use HasFactory;
}
