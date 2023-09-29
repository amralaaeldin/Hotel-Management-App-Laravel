<?php

namespace App\Jobs;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class FreeRoom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $limit = Carbon::now('+02:00')->subDays(35);

        $lastMonthReservations = Reservation::select('room_id', 'st_date', 'end_date')
            ->orderByDesc('st_date')
            ->where('st_date', '>', "$limit->year-$limit->month-$limit->day")
            ->get();

        $unique = $lastMonthReservations->unique('room_id')->values();

        $filtered = $unique->filter(function ($value, $key) {
            $now = date('Y-m-d 01:00');
            return date("$value->end_date 00:00") < $now;
        });

        $rooms = $filtered->pluck('room_id');

        DB::table('rooms')
            ->whereIn('id', $rooms->all())
            ->update(['reserved' => false]);
    }
}
