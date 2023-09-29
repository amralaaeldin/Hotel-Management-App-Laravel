<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return
            [
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => bcrypt('12345678'),
                'gender' => fake()->randomElement(['M', 'F']),
                'mobile' => fake()->phoneNumber,
                'country' => strtolower(fake()->countryCode()),
                'avatar' => '/avatars/clients/clients_default_avatar.png',
                'approved' => fake()->boolean,
                'approved_by' => 1,
                'last_login_at' => fake()->dateTimeBetween('-1 years', 'now'),
            ];
    }
}
