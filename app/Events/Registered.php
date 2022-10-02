<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Registered
{
    use SerializesModels;

    /**
     * The authenticated client.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $client;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $client
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        Mail::send('emails.welcome', ['name' => $this->client->name], function ($message) {
            $message->to($this->client->email, $this->client->name)->subject('Welcome to our Hotel website');
        });
    }
}
