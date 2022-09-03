<?php

namespace Database\Factories;

use App\Models\Category;
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
            'category_id' => Category::all()->random()->id,
            'views' => $views,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'thumbnail' => 'images/2022-08-29/post-' . fake()->unique()->numberBetween(1, env('POSTS_AMOUNT', 13)) . '.jpg'
        ];
    }
}
