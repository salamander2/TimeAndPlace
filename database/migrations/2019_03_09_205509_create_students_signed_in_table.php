<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsSignedInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_signed_in', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('studentID')->unsigned();            
            $table->integer('kiosk_id')->unsigned();
            $table->string('status_code',30)->nullable(); //probably not going to be used
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
        Schema::dropIfExists('students_signed_in');
    }
}
