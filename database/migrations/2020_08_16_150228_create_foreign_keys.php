<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

/*	No onUpdate cascade. That's dumb. Why would be ever be changing the primary key?
	Unless the key is not a sequential ID
*/


// TODO: Kiosks has a "secretURL" foreign key too!

	/********* kiosk_user ******/
	Schema::table('kiosk_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade');
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade');
        });

	/********* kiosk_schedule ******/
	Schema::table('kiosk_schedule', function (Blueprint $table) {
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedules')
                        ->onDelete('cascade');
        });


	/********* students_signed_in *********/
        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->foreign('studentID')->references('studentID')->on('schoolDB.students');
        });
        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade');
        });
        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->foreign('status_code')->references('code')->on('status')
                        ->onUpdate('cascade');
        });

	/********** logs *********/
        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('kiosk_id')->references('id')->on('kiosks')
                        ->onDelete('cascade');
            $table->foreign('status_code')->references('code')->on('status');
        });
	//Delete this: we don't need to enforce this. We could allow priviledges for schoolDB to delete the loggerDB:logs record, but, no.
        //Schema::table('logs', function (Blueprint $table) {
        //    $table->foreign('studentID')->references('studentID')->on('schoolDB.students');
        //});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	Schema::table('kiosk_user', function (Blueprint $table) {
            $table->dropForeign('kiosk_user_user_id_foreign');
            $table->dropForeign('kiosk_user_kiosk_id_foreign');
        });

	Schema::table('kiosk_schedule', function (Blueprint $table) {
            $table->dropForeign('kiosk_schedule_kiosk_id_foreign');
            $table->dropForeign('kiosk_schedule_schedule_id_foreign');
        });

        Schema::table('students_signed_in', function (Blueprint $table) {
            $table->dropForeign('students_signed_in_studentid_foreign');
            $table->dropForeign('students_signed_in_kiosk_id_foreign');
            $table->dropForeign('students_signed_in_status_code_foreign');
        });
        //Schema::table('kiosk_student', function (Blueprint $table) {
        //    $table->dropForeign('kiosk_student_kiosk_id_foreign');
        //});

        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign('logs_kiosk_id_foreign');
            $table->dropForeign('logs_status_code_foreign');
        });

    }
}
