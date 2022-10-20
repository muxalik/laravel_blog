<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = ['Marketing', 'Make Money', 'Blog', 'Programming'];

        return [
            'title' => fake()->unique()->randomElement($categories),
            'created_at' => fake()->dateTimeBetween('-1 year')
        ];
    }
}
