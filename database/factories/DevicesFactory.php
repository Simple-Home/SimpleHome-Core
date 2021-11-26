<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Devices;

class DevicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Devices::class;

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
            'approved' => 'O',
            'sleep' => '0',
            'token' => Str::random(20)
        ];
    }

}
