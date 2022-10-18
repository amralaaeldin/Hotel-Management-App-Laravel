<?php

namespace App\Jobs;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RemindClient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *name
     * @return void
     */
    public function handle()
    {
        Client::select('id', 'name', 'email', 'last_login_at')
        // 10 days remember me cookie lifetime + 10 days delay
            ->where('last_login_at', '<', Carbon::now('+02:00')->subDays(20))
            ->chunkById(200, function ($clientsToRemind) {
                foreach ($clientsToRemind as $client) {
                    Mail::send('emails.visit-us-again', ['name' => $client->name], function ($message) use ($client) {
                        $message->to($client->email, $client->name)->subject('Visit Us Again');
                    });
                }
            }, $column = 'id');
    }
}
