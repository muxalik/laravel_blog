<?php

namespace Tests\Feature\Actions;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class DeleteTagActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Post::truncate();
        Tag::truncate();
        DB::table('post_tag')->truncate();
        User::truncate();
    }

    /** @test */
    public function delete_one_when_exists()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/' . $tag->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/admin/tags');
        $response->assertSessionHas('success');
        $this->assertModelMissing($tag);
    }

    /** @test */
    public function delete_one_when_doesnt_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/4',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(404);
    }

    /** @test */
    public function delete_one_when_related_posts_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $tag = Tag::factory()->create();
        $posts = Post::factory(7)->create();
        $tag->posts()->sync($posts);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/' . $tag->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('error');
        $this->assertModelExists($tag);
    }

    /** @test */
    public function delete_one_when_related_posts_dont_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/' . $tag->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('success');
        $this->assertModelMissing($tag);
    }

    /** @test */
    public function delete_all_when_dont_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('error');
    }

    /** @test */
    public function delete_all_when_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        Tag::factory(4)->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('tags', 0);
    }

    /** @test */
    public function delete_all_when_related_posts_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $tags = Tag::factory(4)->create();
        $posts = Post::factory(6)->create();
        $posts->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(3));
        });

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('tags', 4);
    }

    /** @test */
    public function delete_all_when_related_posts_doesnt_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        Tag::factory(4)->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('tags', 0);
    }
}
