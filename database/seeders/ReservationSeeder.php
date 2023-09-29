<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Reservation;
use App\Models\Room;
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
        Floor::factory(5)->create();

        $rooms = [
            [
                'floor_id' => 1000,
                'capacity' => 2,
                'price' => 200000,
                'created_by' => 1,
                'reserved' => false,
            ],
            [
                'floor_id' => 1000,
                'capacity' => 2,
                'price' => 150000,
                'created_by' => 1,
                'reserved' => false,
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        Room::factory(20)->create([
            'floor_id' => fake()->numberBetween(1000, 1005),
            'capacity' => fake()->numberBetween(1, 4),
            'price' => fake()->numberBetween(100000, 500000),
            'created_by' => 1,
            'reserved' => false,
        ]);

        Reservation::create([
            'client_id' => '1',
            'room_id' => '2',
            'floor_id' => '1000',
            'duration' => '1',
            'price_paid_per_day' => 150000,
            'accompany_number' => '2',
            'st_date' => '2022-09-16',
            'end_date' => '2022-09-17',
        ]);

        Reservation::create([
            'client_id' => '1',
            'room_id' => '2',
            'floor_id' => '1000',
            'duration' => '1',
            'price_paid_per_day' => 150000,
            'accompany_number' => '2',
            'st_date' => '2022-09-29',
            'end_date' => '2022-09-30',
        ]);

        Reservation::create([
            'client_id' => '1',
            'room_id' => '1',
            'floor_id' => '1000',
            'duration' => '1',
            'price_paid_per_day' => 200000,
            'accompany_number' => '2',
            'st_date' => '2022-09-4',
            'end_date' => '2022-09-5',
        ]);

        Reservation::create([
            'client_id' => '1',
            'room_id' => '1',
            'floor_id' => '1000',
            'duration' => '1',
            'price_paid_per_day' => 200000,
            'accompany_number' => '2',
            'st_date' => '2022-09-10',
            'end_date' => '2022-09-11',
        ]);
    }
}
