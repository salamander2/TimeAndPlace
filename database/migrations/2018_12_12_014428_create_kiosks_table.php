<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKiosksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
   */
	public function up()
	{
	  Schema::create('kiosks', function (Blueprint $table) {
			  $table->increments('id');
			  $table->string('name');
			  $table->string('room');
			  $table->string('secretURL');
			  $table->boolean('showPhoto');
			  $table->boolean('showSchedule');
			  $table->boolean('requireConf');
			  $table->boolean('publicViewable');
			  $table->boolean('signInOnly');
			  $table->boolean('autoSignout');
			  $table->string('adminName');
			  $table->string('defaultFreq');
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
	  Schema::dropIfExists('kiosks');
  }
}
