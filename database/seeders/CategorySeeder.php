<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Marketing', 'Make Money', 'Blog', 'Programming'];
        $data = [];

        foreach($categories as $category) {
            $data[] = [
                'title' => $category,
                'slug' => Str::slug($category),
                'created_at' => fake()->dateTimeBetween('-1 year')
            ];
        }

        Category::insert($data);
    }
}
