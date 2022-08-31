<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'name' => fake()->name(),
            'email' => fake()->freeEmail(),
            'phone' => fake()->e164PhoneNumber(),
            'subject' => fake()->word(),
            'message' => fake()->text(200)
        ];
    }
}
