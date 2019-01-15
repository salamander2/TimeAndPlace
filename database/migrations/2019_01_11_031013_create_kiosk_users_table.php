<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKioskUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosk_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('userID')->unsigned();
            $table->integer('kioskID')->unsigned();
            $table->boolean('isKioskAdmin');    //is this users an administrator of this kiosk?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kiosk_users');
    }
}
