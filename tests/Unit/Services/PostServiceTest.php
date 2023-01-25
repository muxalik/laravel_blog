<?php

namespace Tests\Unit\Services;

use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected PostService $service;

    public function setUp(): void 
    {
        parent::setUp();

        $this->service = new PostService();
    }

    /** @test */
    public function post_can_be_retrieved_by_slug()
    {
        $post = Post::factory()->create();

        $actual = $this->service::getWithIncrement($post->slug);

        $this->assertTrue($post->is($actual));
        $this->assertEquals($post->views + 1, $actual->views);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'views' => $post->views + 1]);
    }

    /** @test */
    public function post_cannot_be_retreived_by_slug()
    {
        $this->expectException(ModelNotFoundException::class);
        $post = Post::factory()->makeOne();

        $actual = $this->service::getWithIncrement($post->slug);

        $this->assertNull($actual);
        $this->assertDatabaseMissing('posts', ['id' => $post->id, 'views' => $post->views]);
    }

    /** @test */
    public function similar_posts_can_be_retrieved()
    {
        $tags = Tag::factory(10)->create();
        $posts = Post::factory(5)->create();
        $posts->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(rand(2, 9)));
        });

        $randomPost = $posts->random();
        $similar = $this->service::getSimilar($randomPost);

        $this->assertEquals(2, $similar->count());
        $similar->each(function ($post) use ($randomPost) {
            $this->assertFalse($randomPost->is($post));
        });
    }

    /** @test */
    public function get_similar_posts_when_dont_exist()
    {
        $post = Post::factory()->create();
        $tags = Tag::factory(6)->create();
        $post->tags()->sync($tags);

        $similar = $this->service::getSimilar($post);
        
        $this->assertEmpty($similar);
    }
}
