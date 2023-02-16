<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class WelcomeEmailNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sent_to_specific_user()
    {
        Notification::fake();
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });

        $user->notify(new WelcomeEmailNotification());

        Notification::assertCount(1);
        Notification::assertSentTo($user, WelcomeEmailNotification::class);
    }

    /** @test */
    public function sent_to_group_of_users()
    {
        Notification::fake();
        $users = User::withoutEvents(function () {
            return User::factory(7)->create();
        });

        $users->each(function ($user) {
            $user->notify(new WelcomeEmailNotification());
        });

        Notification::assertCount($users->count());
        $users->each(function ($user) {
            Notification::assertSentTo($user, WelcomeEmailNotification::class);
        });
    }
}
