<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	 DB::table('status')->insert([
            'code' => 'SIGNIN',
            'text' => 'Sign In',
            'description' => 'Sign in to the terminal',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
	 DB::table('status')->insert([
            'code' => 'SIGNOUT',
            'text' => 'Sign Out',
            'description' => 'Sign out of the terminal',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
	 DB::table('status')->insert([
            'code' => 'AUTOSIGNOUT',
            'text' => '[Auto Sign Out]',
            'description' => 'Auto signout by system',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
	 DB::table('status')->insert([
            'code' => 'PRESENT',
            'text' => 'Present',
            'description' => 'Sign in when there is no signout',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

