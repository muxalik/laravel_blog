<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
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
        $posts = Post::factory(env('POST_AMOUNT', 13))->create();
        $min = 3;
        $max = 10 <= env('TAGS_AMOUNT', 17) ? 10 : env('TAGS_AMOUNT');

        // post_tag table
        Tag::all()->each(function ($tag) use ($posts, $min, $max) {
            $tag->posts()->attach(
                $posts->random(fake()->numberBetween($min, $max))
                    ->pluck('id')->toArray()
            );
        });
    }
}
