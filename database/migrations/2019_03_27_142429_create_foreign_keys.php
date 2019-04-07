<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	/********* kiosk_user ******/
	Schema::table('kiosk_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
        Schema::table('kiosk_user', function (Blueprint $table) {
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });


	/********* students_signed_in *********/
        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->foreign('studentID')->references('studentID')->on('schoolDB.students')
//                        ->onDelete('cascade')
//                        ->onUpdate('cascade');
		;
        });
        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->foreign('status_code')->references('code')->on('status');
        });

	/********** logs *********/
        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
	//Delete this: we don't need to enforce this. We could allow priviledges for schoolDB to delete the loggerDB:logs record, but, no.
        //Schema::table('logs', function (Blueprint $table) {
        //    $table->foreign('studentID')->references('studentID')->on('schoolDB.students');
        //});

        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('status_code')->references('code')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

	//TODO : this does not have all of the foreign keys listed above
    public function down()
    {
	/*
	Schema::table('kiosk_user', function (Blueprint $table) {
            $table->dropForeign('kiosk_user_user_id_foreign');
        });
        Schema::table('kiosk_user', function (Blueprint $table) {
            $table->dropForeign('kiosk_user_kiosk_id_foreign');
        });
        //Schema::table('kiosk_student', function (Blueprint $table) {
        //    $table->dropForeign('kiosk_student_student_id_foreign');
        //});
        //Schema::table('kiosk_student', function (Blueprint $table) {
        //    $table->dropForeign('kiosk_student_kiosk_id_foreign');
        //});
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign('logs_kiosk_id_foreign');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign('logs_student_id_foreign');
        });
	*/
    }
}
