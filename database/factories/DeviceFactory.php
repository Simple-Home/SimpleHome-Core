<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = array("light", "toggle", "speaker", "sensor");
        $rand_key = array_rand($types);
        return [
            'hostname' => $this->faker->words(3, true),
            'type' => $types[$rand_key],
            'heartbeat' => now(),
            'approved' => '1',
            'sleep' => '0',
            'token' => Str::random(20)
        ];
    }

}
