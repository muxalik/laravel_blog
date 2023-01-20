<?php

namespace App\Listeners;

use App\Events\SubscriberAdded;
use App\Notifications\NewSubscriberNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SubscriberAddedListener
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
     * @param  SubscriberAdded  $event
     * @return void
     */
    public function handle(SubscriberAdded $event)
    {
        Notification::route('mail', $event->email)->notify(new NewSubscriberNotification(
                email: $event->email, 
                name: $event->name
            ));
    }
}
