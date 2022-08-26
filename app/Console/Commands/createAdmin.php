<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            if (!$this->option('email') || !filter_var($this->option('email'), FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email.";
                return;
            }
            if (!$this->option('password') || strlen($this->option('password')) < 8) {
                echo "Invalid password, The password must be at least 8 characters.";
                return;
              }
            User::create(['name' => $this->option('name'), 'email' => $this->option('email'), 'password' => Hash::make($this->option('password'))])
            ->assignRole(['name' => 'admin']);
            echo 'Created Successfully!';
            return 0;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
