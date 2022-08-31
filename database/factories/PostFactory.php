<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $views    = fake()->numberBetween(700, 5000);
        $likes    = fake()->numberBetween(200, floor($views / 4));
        $dislikes = fake()->numberBetween(50, floor($likes / 2));

        return [
            'title' => fake()->text(60),
            'description' => fake()->paragraph(4),
            'content' => fake()->text(3000),
            'category_id' => fake()->numberBetween(1, 4),
            'views' => $views,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'thumbnail' => 'images/2022-08-29/post-' . fake()->unique()->numberBetween(1, 13) . '.jpg'
        ];
    }
}
