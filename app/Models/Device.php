<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Properties;

class Device extends Model
{
	public $incrementing = true;
    protected $table = 'devices';
    protected $primaryKey = 'id';
	protected $fillable = [
		'hostname',
		'type',
		'approved'
	];
	use HasFactory;
}
