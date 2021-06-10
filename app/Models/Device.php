<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Device
 * 
 * @property int $id
 * @property string $device
 * @property string $deviceType
 * @property string $binding
 * @property string $password
 * @property string $default_on
 * @property string $default_off
 * @property string $protocol
 * @property string $ip
 * @property string $state
 * @property int $room_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Room $room
 *
 * @package App\Models
 */
class Device extends Eloquent
{
	protected $casts = [
		'room_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'device',
		'deviceType',
		'binding',
		'password',
		'default_on',
		'default_off',
		'protocol',
		'ip',
		'state',
		'room_id'
	];

	public function room()
	{
		return null;
	}
}
