<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservation::create([
            'client_id' => '1',
            'room_number' => '11',
            'floor_number' => '1000',
            'duration' => '1',
            'price_paid_per_day' => '1500',
            'accompany_number' => '2',
            'st_date' => '2022-09-16',
            'end_date' => '2022-09-17',
        ]);
        Reservation::create([
            'client_id' => '1',
            'room_number' => '11',
            'floor_number' => '1000',
            'duration' => '1',
            'price_paid_per_day' => '1500',
            'accompany_number' => '2',
            'st_date' => '2022-09-29',
            'end_date' => '2022-09-30',
        ]);
        Reservation::create([
            'client_id' => '1',
            'room_number' => '1202',
            'floor_number' => '1000',
            'duration' => '1',
            'price_paid_per_day' => '2000',
            'accompany_number' => '2',
            'st_date' => '2022-09-4',
            'end_date' => '2022-09-5',
        ]);
        Reservation::create([
            'client_id' => '1',
            'room_number' => '1202',
            'floor_number' => '1000',
            'duration' => '1',
            'price_paid_per_day' => '2000',
            'accompany_number' => '2',
            'st_date' => '2022-09-10',
            'end_date' => '2022-09-11',
        ]);
    }
}
