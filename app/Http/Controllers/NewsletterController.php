<?php

namespace App\Http\Controllers;

use App\Events\SubscriberAdded;
use App\Http\Requests\NewsletterRequest;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(NewsletterRequest $request)
    {
        Subscriber::create(array_merge(
            $request->validated(),
            ['user_id' => !auth()->check() ?: auth()->id()]
        ));

        event(new SubscriberAdded(
            email: $request->input('email'), 
            name: auth()->check() ? auth()->user()->name : 'Guest' 
        ));

        return back();
    }
}
