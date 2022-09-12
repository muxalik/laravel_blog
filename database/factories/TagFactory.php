<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tags = ['SEO', 'Digital Agency', 'Blogging', 'Video Tuts', 'Teamwork', 'Coding', 'Books', 'Frontend', 'Backend', 'HTML', 'CSS', 'JavaScript', 'Python', 'PHP', 'C#', 'Java', 'Game Development'];

        return [
            'title' => fake()->unique()->randomElement($tags),
            'created_at' => fake()->dateTimeBetween('-1 year')
        ];
    }
}
