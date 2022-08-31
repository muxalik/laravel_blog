<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(env('POST_AMOUNT', 13))->create();
        $posts = Post::all();
        $min = 3;
        $max = 10 <= env('TAGS_AMOUNT', 17) ? 10 : env('TAGS_AMOUNT');

        Tag::all()->each(function ($tag) use ($posts, $min, $max) {
            $tag->posts()->attach(
                $posts->random(fake()->numberBetween($min, $max))->pluck('id')->toArray()
            );
        });
    }
}
