<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_category_can_be_retrieved_using_slug(): void
    {
        $category = Category::factory()->create();
        $this->assertTrue($category->is(Category::getBySlug($category->slug)));
    }

    public function test_category_can_get_amount_of_related_posts(): void
    {
        $category = Category::factory(4)->create()->first();
        $posts = Post::factory(5)->create(['category_id' => $category->id]);
        $this->assertSame($category->getPostsAmount(), $posts->count());
    }
}
