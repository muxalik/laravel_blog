<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\NewSubscriberNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NewSubscriberNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sent_to_specific_user()
    {
        Notification::fake();
        $user = User::factory()->create();

        $user->notify(new NewSubscriberNotification($user->email, $user->name));
        
        Notification::assertCount(1);
        Notification::assertSentTo($user, NewSubscriberNotification::class);
    }

    /** @test */
    public function sent_to_group_of_users()
    {
        Notification::fake();
        $users = User::factory(12)->create();
        $user = User::factory()->create();

        $users->each(function ($user) {
            $user->notify(new NewSubscriberNotification($user->email, $user->name));
        });
        
        Notification::assertCount($users->count());
        Notification::assertSentTo($users, NewSubscriberNotification::class);
        Notification::assertNotSentTo($user, NewSubscriberNotification::class);    
    }
}
