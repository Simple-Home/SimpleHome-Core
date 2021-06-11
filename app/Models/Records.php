<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Properties;

class Records extends Model
{
    public $incrementing = true;
    protected $table = 'records';
    protected $primaryKey = 'id';
    public $fillable = [
        "value",
        "done",
    ];
    use HasFactory;
}
