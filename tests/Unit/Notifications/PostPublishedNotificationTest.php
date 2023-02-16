<?php

namespace Tests\Unit\Notifications;

use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PostPublishedNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sent_to_specific_subscriber()
    {
        Notification::fake();
        $subscriber = Subscriber::factory()->create();
        $post = Post::withoutEvents(function () {
            return Post::factory()->create(['slug' => '2rklkjg34yrbc']);
        });

        $subscriber->notify(new PostPublishedNotification($post, $subscriber->email));

        Notification::assertCount(1);
        Notification::assertSentTo($subscriber, PostPublishedNotification::class);
    }

    /** @test */
    public function sent_to_group_of_subscribers()
    {
        Notification::fake();
        $subscribers = Subscriber::factory(12)->create();
        $subscriber = Subscriber::factory()->create();
        $post = Post::withoutEvents(function () {
            return Post::factory()->create(['slug' => '2rklkjg34yrbc']);
        });

        $subscribers->each(function ($subscriber) use ($post) {
            $subscriber->notify(new PostPublishedNotification($post, $subscriber->email));
        });

        Notification::assertCount($subscribers->count());
        Notification::assertSentTo($subscribers, PostPublishedNotification::class);
        Notification::assertNotSentTo($subscriber, PostPublishedNotification::class);
    }
}
