<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lockers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->integer('status'); // 0 = available, -1 = damaged, -2 = non existent, 1=in use
			$table->integer('student1')->unsigned; //should these be unique?
			$table->integer('student2')->unsigned;
			$table->integer('student3')->unsigned;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lockers');
    }
}
