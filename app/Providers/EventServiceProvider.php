<?php

namespace App\Providers;

use App\Events\PostCreated;
use App\Events\SubscriberAdded;
use App\Listeners\PostPublishedListener;
use App\Listeners\SubscriberAddedListener;
use App\Listeners\WelcomeEmailListener;
use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            WelcomeEmailListener::class,
        ],
        SubscriberAdded::class => [
            SubscriberAddedListener::class,
        ],
        PostCreated::class => [
            PostPublishedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
