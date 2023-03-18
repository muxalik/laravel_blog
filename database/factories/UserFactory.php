<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $registry = fake()->optional(0.3, fake()->unique()->dateTimeThisYear())->dateTimeBetween('-2 year');

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->freeEmail(),
            'password' => fake()->password(),
            'is_admin' => fake()->optional(0.9, 1)->randomElement([0]),
            'created_at' => $registry,
            'updated_at' => fake()->dateTimeBetween($registry),
        ];
    }
}
