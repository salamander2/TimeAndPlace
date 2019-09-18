<?php

use Illuminate\Database\Seeder;

class LockerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 3500; $i++) { 

	    	DB::table('lockers')->insert([
				'status'=> 0,
	        ]);

    	}   
    }
}
