<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Properties;

class Property extends Model
{
	public $incrementing = true;
    protected $table = 'properties';
    protected $primaryKey = 'id';
	protected $fillable = [
		'property',
		'type',
		'binding',
		'icon',
		'nick_name',
		'device_id',
		'room_id',
		'history'
	];
	use HasFactory;
}
