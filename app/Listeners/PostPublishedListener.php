<?php

namespace App\Listeners;

use App\Models\Subscriber;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class PostPublishedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Subscriber::chunk(100, function ($subscribers) use ($event) {
            $subscribers->each(function ($subscriber) use ($event) {
                Notification::route('mail', $subscriber->email)
                    ->notify(new PostPublishedNotification(
                        post: $event->post,
                        email: $subscriber->email
                    ));
            });
        });
    }
}
