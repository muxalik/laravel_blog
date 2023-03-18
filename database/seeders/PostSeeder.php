<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        
        for ($i = 0; $i < env('POST_AMOUNT', 13); $i++) {
            $views    = fake()->numberBetween(700, 5000);
            $likes    = fake()->numberBetween(200, floor($views / 4));
            $dislikes = fake()->numberBetween(50, floor($likes / 2));   
            $title = fake()->text(60);

            $data[] = [
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => fake()->paragraph(4),
                'content' => fake()->text(3000),
                'category_id' => fake()->randomElement(range(1, env('CATEGORIES_AMOUNT', 4))),
                'views' => $views,
                'likes' => $likes,
                'dislikes' => $dislikes,
                'thumbnail' => 'images/2022-08-29/post-' . fake()->unique()->numberBetween(1, env('POSTS_AMOUNT', 13)) . '.jpg',
                'created_at' => fake()->dateTimeBetween('-1 year')
            ];
        }

        Post::insert($data);
        
        $count = Tag::count();
        $data = [];
        $posts = Post::inRandomOrder()->get();
        $min = 3;
        $max = 10 <= env('TAGS_AMOUNT', 17) ? 10 : env('TAGS_AMOUNT');

        for ($tagId = 0; $tagId < $count; $tagId++) {
            $created_at = fake()->dateTimeBetween('-1 year');
            $randomPosts = $posts->random(rand($min, $max));

            foreach ($randomPosts as $post) {
                $data[] = [
                    'post_id' => $post->id,
                    'tag_id' => $tagId,
                    'created_at' => $created_at,
                    'updated_at' => fake()->dateTimeBetween($created_at),
                ];
            }
        }
        
        DB::table('post_tag')->insert($data);
    }
}
