<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('studentID')->unsigned();
            $table->integer('kiosk_id')->unsigned();
            $table->string('status',30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('past_logs');
    }
}
