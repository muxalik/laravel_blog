<?php

namespace App\Listeners;

use App\Models\Subscriber;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PostPublishedListener implements ShouldQueue
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
        DB::table('subscribers')->chunk(100, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                Notification::route('mail', $subscriber->email)
                    ->notify(new PostPublishedNotification(
                        post: $this->event->post, 
                        email: $subscriber->email
                    ));
            }
        });
    }
}
