<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'floor_id' => fake()->numberBetween(1000, 1005),
            'capacity' => fake()->numberBetween(1, 4),
            'price' => fake()->numberBetween(100000, 500000),
            'created_by' => 1,
            'reserved' => false,
        ];
    }
}
