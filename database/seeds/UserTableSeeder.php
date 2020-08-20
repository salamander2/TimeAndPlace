<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	//insert record for adminstrative user
        DB::table('users')->insert([
		'username' => 'admin',		//PLEASE change this to something else
		'fullname' => 'Database Administrator',
		'password' => password_hash('CanoeFloral', PASSWORD_DEFAULT),
		'isAdmin'  => 1,
		'viewAll'  => 1,
                'defaultPWD' => 1,
                'isDefaultUser' => 0
	]);
    }

/*
	Schema::create('users', function (Blueprint $table) {
		$table->increments('id');					// not used, but basically required for users in Laravel
		$table->string('username')->unique();		// this is essentially the primary key. Needs indexing?
		$table->string('fullname');					//
		$table->boolean('isAdmin')->default(0);		// is the user one of the 2 or 3 admins? (add users, create kiosks)
		$table->boolean('viewAll')->default(0); 	// is the user a VP who is allowed to viewall attendance data
		//$table->string('email')->unique();
		$table->string('password');
		$table->boolean('defaultPWD')->default(1);	// is the user still using the default password?
		$table->boolean('isDefaultUser')->default(0);	// is this the default user (there should only be one) - for view-only usage
		$table->rememberToken();					// probably never used. Not clear about it.
		$table->timestamps();
		});
	}
*/

}
