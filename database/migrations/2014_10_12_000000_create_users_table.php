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
				$table->increments('id');
				$table->string('username')->unique();
				$table->string('fullname');
				$table->boolean('isAdmin')->default(0);
				$table->boolean('viewAll')->default(0);
				//$table->string('email')->unique();
				$table->string('password');
				$table->boolean('defaultPWD')->default(1);
				$table->rememberToken();
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
