<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LockerStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		 DB::table('locker_status')->insert([
			'id' => 0,
            'status' => 'Available',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
		 DB::table('locker_status')->insert([
			'id' => -1,
            'status' => 'Damaged',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
		 DB::table('locker_status')->insert([
			'id' => -2,
            'status' => 'Nonexistent',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
	 DB::table('locker_status')->insert([
			'id' => 1,
            'status' => 'Assigned',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
