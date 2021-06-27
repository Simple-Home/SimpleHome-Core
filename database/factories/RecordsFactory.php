<?php

namespace Database\Factories;

use App\Models\Records;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Records::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $value = [
            'properties' => [
                [
                    "humi" => random_int(0, 100),
                    "wifi" => random_int(-100, 0),
                    "light" => random_int(-100, 0),
                    "co2" => random_int(-100, 0),
                    "temp" => random_int(-5, 70),
                    "batt" => random_int(-1, 4.7),
                ]
            ]
        ];

        return [
            'value' => json_encode($value),
            'created_at' => $this->faker->dateTimeBetween(),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
            'done' => $this->faker->boolean(),
            'property_id' => $this->faker->randomDigitNotZero(),
        ];
    }
}
