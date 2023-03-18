<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::inRandomOrder()->chunk(50, function ($posts) {
            $posts->each(function ($post) {
                Comment::factory($this->getAmount())->state(new Sequence(
                    ['post_id' => $post->id]
                ))->create();
            });
        });
    }

    protected function getAmount()
    {   
        $min = env('MIN_COMMENTS_AMOUNT_PER_POST', 4);
        $max = env('MAX_COMMENTS_AMOUNT_PER_POST', 17);

        return rand($min, $max);
    }
}
