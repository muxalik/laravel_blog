<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPost extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public Post $post,
        public string $email
    ) {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)->view('mail.newpost');
    }
}
