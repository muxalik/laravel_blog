<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['SEO', 'Digital Agency', 'Blogging', 'Video Tuts', 'Teamwork', 'Coding', 'Books', 'Frontend', 'Backend', 'HTML', 'CSS', 'JavaScript', 'Python', 'PHP', 'C#', 'Java', 'Game Development'];
        $data = [];

        foreach ($tags as $tag) {
            $data[] = [
                'title' => $tag,
                'slug' => Str::slug($tag),
                'created_at' => fake()->dateTimeBetween('-1 year')
            ];
        }

        foreach (array_chunk($data, 50) as $chunk) {
            Tag::insert($chunk);
        }
    }
}
