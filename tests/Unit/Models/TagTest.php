<?php

namespace Tests\Unit\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_many_posts()
    {
        $tags = Tag::factory(10)->create();
        $posts = Post::factory(3)->create();

        $posts->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(rand(3, 9)));
        });

        $this->assertEquals(Post::whereHas('tags')->count(), $posts->count());
        $this->assertTrue($posts->every(function ($post) {
            return $post->tags->count() > 2;
        }));
    }

    /** @test */
    public function it_can_be_retrieved_by_slug()
    {
        $tag = Tag::factory()->create();

        $this->assertTrue($tag->is(Tag::getBySlug($tag->slug)));
    }

    /** @test */
    public function get_most_popular()
    {
        $tags = Tag::factory(10)->create();
        $posts = Post::factory(6)->create();

        $posts->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(rand(3, 10)));
        });
        $tags = Tag::getPopular();
        
        $this->assertNotNull($tags->every(function ($tag) {
            return $tag->title && $tag->posts_count;
        }));
        $this->assertEquals($tags, $tags->sortByDesc('posts_count'));
        $this->assertSame(6, $tags->count());
    }
}
