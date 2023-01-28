<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    protected function makeCategory($number = null): Category|Collection
    {
        return Category::factory($number)->create();
    }

    protected function makePost($categoryId, $number = null): Post|Collection
    {
        return Post::factory($number)->create([
            'category_id' => $categoryId
        ]);
    }

    /** @test */
    public function homepage_contains_posts()
    {
        $category = $this->makeCategory();
        $posts = $this->makePost($category->id, 3);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $posts->each(function ($post) use ($response) {
            $response->assertViewHas('posts', function ($collection) use ($post) {
                return $collection->contains($post);
            });
        });
    }

    /** @test */
    public function homepage_pagination_works()
    {
        $category = $this->makeCategory();
        $posts = $this->makePost($category->id, 4)->sortByDesc('created_at');
        $lastPost = $posts->last();

        $response = $this->get('/?page=2');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts', function ($collection) use ($lastPost) {
            return $collection->contains($lastPost);
        });
    }

    /** @test */
    public function homepage_contains_popular_posts()
    {
        $category = $this->makeCategory();
        $posts = $this->makePost($category->id, 7)
            ->sortByDesc('views')->take(3);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee($posts->get('title'));
    }

    /** @test */
    public function show_page_has_content()
    {
        $category = $this->makeCategory();
        $post = $this->makePost($category->id);
        $tags = Tag::factory(3)->create();
        $post->tags()->sync($tags);

        $response = $this->get('/article/' . $post->slug);

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $response->assertSee($post->title);
        $response->assertSee($post->content);
        $response->assertSee($post->likes);
        $response->assertSee($post->dislikes);
        $tags->each(function ($tag) use ($response) {
            $response->assertSee($tag->title);
        });
    }

    /** @test */
    public function show_page_contains_popular_posts()
    {
        $category = $this->makeCategory();
        $posts = $this->makePost($category->id, 7)
            ->sortByDesc('views')->take(3);

        $response = $this->get('/article/' . $posts->first()->slug);

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertSee($posts->get('title'));
    }

    /** @test */
    public function show_page_contains_recent_posts()
    {
        $category = $this->makeCategory();
        $posts = $this->makePost($category->id, 7)
            ->sortByDesc('id')->take(3);

        $response = $this->get('/article/' . $posts->first()->slug);

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertSee($posts->get('title'));
    }
}
