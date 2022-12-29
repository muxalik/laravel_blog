<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_user()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id
        ]);
        
        $this->assertTrue($user->is($comment->user));
    }

    /** @test */
    public function it_belongs_to_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id
        ]);

        $this->assertTrue($post->is($comment->post));
    }

    /** @test */
    public function field_created_at_is_formatted_while_retrieving()
    {
        $date = fake()->dateTimeBetween('-1 year');
        $comment = Comment::factory()->create([
            'created_at' => $date
        ]);

        $formatted = Carbon::parse($date)->diffForHumans();

        $this->assertEquals($formatted, $comment->created_at);
    }

    /** @test */
    public function it_can_be_retrieved_by_post_id()
    {
        $post = Post::factory()->create();
        Comment::factory(6)->create([
            'post_id' => $post->id
        ]);

        $actual = Comment::where('post_id', $post->id)
            ->oldest()
            ->paginate(4);

        $this->assertEquals(Comment::getByPostId($post->id), $actual);
    }
}


