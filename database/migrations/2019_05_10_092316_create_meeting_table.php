<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* This table will record when the meetings are for any kiosk that is signin-only 
           So that we can generate reports, see who arrived late, etc. */
        Schema::create('meeting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kiosk_id')->unsigned();
            $table->time('time');
            $table->date('date');
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
        Schema::dropIfExists('meeting');
    }
}
