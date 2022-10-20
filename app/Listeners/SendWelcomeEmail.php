<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::send('emails.welcome', ['name' => $event->user->name], function ($message) use ($event) {
            $message->to($event->user->email, $event->user->name)->subject('Welcome to our Hotel website');
        });
    }
}
