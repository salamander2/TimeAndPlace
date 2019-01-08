<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
				$table->increments('id');					// not used, but basically required for users in Laravel
				$table->string('username')->unique();		// this is essentially the primary key. Needs indexing?
				$table->string('fullname');					//
				$table->boolean('isAdmin')->default(0);		// is the user one of the 2 or 3 admins? (add users, create kiosks)
				$table->boolean('viewAll')->default(0); 	// is the user a VP who is allowed to viewall attendance data
				//$table->string('email')->unique();
				$table->string('password');
				$table->boolean('defaultPWD')->default(1);	// is the user still using the default password?
				$table->rememberToken();					// probably never used. Not clear about it.
				$table->timestamps();
				});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
