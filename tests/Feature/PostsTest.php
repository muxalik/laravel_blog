<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function homepage_contains_posts()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $response = $this->get('/');

        $this->assertGuest();
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts', function ($collection) use ($post) {
            return $collection->contains($post);
        });
    }
}
