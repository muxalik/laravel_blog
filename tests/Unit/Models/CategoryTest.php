<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_category_is_retrieved_using_slug()
    {
        $category = Category::factory()->create();
        $this->assertTrue($category->is(Category::getBySlug($category->slug)));
    }

    public function test_category_gets_amount_of_related_posts()
    {
        $category = Category::factory(4)->create()->first();
        $posts = Post::factory(5)->create(['category_id' => $category->id]);
        $this->assertSame($category->getPostsAmount(), $posts->count());
    }

    // public function test_category_gets_list()
    // {
    //     Category::factory(4)->create();
    //     Post::factory(10)->create();
        
    //     $collection = Category::withCount('posts')
    //         ->orderByDesc('posts_count')
    //         ->get();

    //     $this->assertTrue($collection->contains('posts_count', ))
    // }
}
