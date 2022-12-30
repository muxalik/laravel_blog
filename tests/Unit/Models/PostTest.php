<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\isEmpty;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_tags()
    {
        $post = $this->createPosts();
        $tags = Tag::factory(7)->create();

        $tagsIds = $tags->map(function ($tag) {
            return $tag->id;
        });
        $post->tags()->sync($tagsIds);
        
        $actualIds = $post->tags->map(function ($tag) {
            return $tag->id;
        });

        $this->assertEquals($tagsIds, $actualIds);
    }

    /** @test */
    public function it_belongs_to_category()
    {
        $category = Category::factory()->create();
        $post = $this->createPosts(args: [
            'category_id' => $category->id
        ]);

        $this->assertTrue($category->is($post->category));
    }

    /** @test */
    public function it_has_many_comments()
    {
        $post = $this->createPosts();
        $comments = Comment::factory(9)->create([
            'post_id' => $post->id
        ]);

        $this->assertEquals($comments->toArray(), $post->comments->toArray());
    }

    /** @test */
    public function its_thumbnail_can_be_retrieved()
    {
        $thumbnail = 'images/testing/post-' . fake()->unique()->numberBetween(1, env('POSTS_AMOUNT', 13)) . '.jpg';
        $post = $this->createPosts(args: ['thumbnail' => $thumbnail]);

        $this->assertEquals(asset('uploads/' . $thumbnail), $post->thumbnail);
    }

    /** @test */
    public function its_thumbnail_has_default_value_if_empty()
    {
        $post = $this->createPosts(args: ['thumbnail' => null]);
        $path = asset("images/icons/no-image_1.png");

        $this->assertNotNull($post->thumbnail);
        $this->assertEquals($path, $post->thumbnail);
    }

    /** @test */
    public function its_image_is_uploaded()
    {
        $image1 = new File(public_path('images\photo1.png'));
        $image2 = new File(public_path('images\photo2.png'));
        
        $thumbnail1 = Post::uploadImage($image1);

        $this->assertFileExists(public_path("uploads\\{$thumbnail1}"));
        
        $thumbnail2 = Post::uploadImage($image2, $thumbnail1);

        $this->assertFileDoesNotExist(public_path("uploads\\{$thumbnail1}"));
        $this->assertFileExists(public_path("uploads\\{$thumbnail2}"));

        Storage::delete($thumbnail2);
    }

    /** @test */
    public function its_rating_can_be_retrieved()
    {
        $posts = Post::factory(5)->create([
            'likes' => fake()->numberBetween(200, 500),
            'dislikes' => fake()->numberBetween(50, 300)
        ]);

        $actual = Post::getRating();

        $this->assertIsNotArray($actual);
        $this->assertEquals($posts->pluck('likes', 'dislikes'), $actual);
    }

    /** @test */
    public function get_most_popular()
    {
        Post::factory(4)->create();

        $expected = Post::orderByDesc('views')->get();
        $actual = Post::getPopular();

        $this->assertNotEquals($expected, $actual);
        $this->assertNotContains($expected->last(), $actual);
        
        $expected = $expected->slice(0, 3);

        $this->assertEquals($expected->count(), $actual->count());
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function get_recent()
    {
        Post::factory(4)->create();
        
        $expected = Post::orderByDesc('id')->get();
        $actual = Post::getRecent();

        $this->assertNotEquals($expected, $actual);
        $this->assertNotContains($expected->last(), $actual);
        
        $expected = $expected->slice(0, 3);

        $this->assertEquals($expected->count(), $actual->count());
        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function get_popular_statistics()
    {
        $this->createPosts(8);
        
        $fields = ['likes', 'dislikes', 'created_at'];
        $posts = Post::orderBy('views')->get();
        $actual = Post::getPopularStats();

        $this->testStatistics($posts, $fields, $actual, sortBy: 'created_at');
    }

    /** @test */
    public function get_recent_statistics()
    {
        $this->createPosts(8);

        $fields = ['likes', 'dislikes', 'views', 'created_at'];
        $posts = Post::orderBy('created_at')->get();
        $actual = Post::getRecentStats();

        $this->testStatistics($posts, $fields, $actual);
    }

    private function testStatistics(
        $posts, 
        array $fields, 
        $actual, 
        string $sortBy = null)
    {
        $this->assertNotEquals($posts->keys(), $actual->keys());
        $this->assertTrue($actual->every(function ($post) use ($fields) {
            return collect($post)->has($fields);
        }));
        $this->assertNotEquals($posts->count(), $actual->count());
        
        $sliced = $posts->slice(0, 7)
            ->when(! isEmpty($sortBy), function ($collection) use ($sortBy) {
                return $collection->sortBy($sortBy);
            });

        $this->assertEquals($sliced->count(), $actual->count());
        
        $mapped = $this->getOnlyFields($sliced, $fields); 
        $actual = $this->getOnlyFields($actual, $fields);
        
        $this->assertEquals($mapped, $actual);
    }

    private function getOnlyFields($collection, array $fields = null): Collection
    {
        return $collection->map(function ($post) use ($fields) {
            return $post->only($fields);
        });
    }

    private function createPosts(int $amount = null, array $args = null): Post | EloquentCollection
    {
        return Post::factory($amount)->create($args);
    }
}
