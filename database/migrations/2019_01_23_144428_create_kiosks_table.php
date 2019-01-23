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
			  $table->increments('id');				// primary key
			  $table->string('name');				// kiosk name
			  $table->string('room');				// location
			  $table->string('secretURL');			// for autologging in a kiosk
			  $table->boolean('showPhoto')->default(0);			// show photo of student when logging in/out
			  $table->boolean('showSchedule')->default(0); 		// show student timetable
			  $table->boolean('requireConf')->default(0);		// require confirmation for login (i.e. name and photo remains until Y is pressed)
			  $table->boolean('publicViewable')->default(0);	// can this kiosk be viewed by the generic "teacher" login?
			  $table->boolean('signInOnly')->default(0);		// sign in or sign in AND sign out
			  $table->boolean('autoSignout')->default(0);		// does this kiosk hav autosignout at certain times?
													// *** the following item should be moved to a separate table
			  $table->string('adminName')->default('-');			// who is the name of the administrator(s) for this kiosk
			  $table->string('defaultFreq')->default('Day');		// what is the default timespan for reporting
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
