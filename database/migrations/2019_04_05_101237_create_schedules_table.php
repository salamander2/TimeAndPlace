<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            //start and altstart are not used for schedules which are 5 minute intervals
            $table->increments('id');           
            $table->string('code',20)->unique();
            $table->time('start');
            $table->time('end');
            $table->time('altstart');
            $table->time('altend');
            $table->string('description',40)->default('');  //probably not used            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
