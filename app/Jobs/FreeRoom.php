<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FreeRoom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The podcast instance.
     *
     * @var \App\Models\Podcast
     */
    public $room;

    /**
     * Create a new job instance.
     *
     * @param  App\Models\Room  $room
     * @return void
     */
    public function __construct(Room $Room)
    {
        $this->room = $room;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $limit = Carbon::now('+02:00')->subDays(35);

        $lastMonthReservations = Reservation::select('room_number', 'st_date', 'end_date')
            ->orderByDesc('st_date')
            ->where('st_date', '>', "$limit->year-$limit->month-$limit->day")
            ->get();

        $unique = $lastMonthReservations->unique('room_number')->values();

        $filtered = $unique->filter(function ($value, $key) {
            $now = date('Y-m-d 01:00');
            return date("$value->end_date 00:00") < $now;
        });

        $rooms = $filtered->pluck('room_number');

        $updatedRooms = DB::table('rooms')
            ->whereIn('room_number', $rooms->all())
            ->update(['reserved' => false]);
    }
}
