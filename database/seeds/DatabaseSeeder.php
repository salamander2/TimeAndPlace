<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(ScheduleTableSeeder::class);
        $this->call(LockerStatusTableSeeder::class);
        $this->call(LockerTableSeeder::class);
    }
}
