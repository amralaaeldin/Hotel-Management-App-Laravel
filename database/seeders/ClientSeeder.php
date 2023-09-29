<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;


class ClientSeeder extends Seeder
{
    public function run()
    {
        Client::factory()->count(20)->create();
    }
}
