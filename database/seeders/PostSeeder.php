<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Database\Factories\CommentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        // Post_tag table
        Tag::all()->each(function ($tag) use ($posts, $min, $max) {
            $tag->posts()->attach(
                $posts->random(fake()->numberBetween($min, $max))->pluck('id')->toArray()
            );
        });

        // Comments table
        $posts->each(function ($post) {
            Comment::factory(env('COMMENTS_AMOUNT_PER_POST', 5))->state(new Sequence(
                ['post_id' => $post->id]
            ))->create();
        });
    }
}
