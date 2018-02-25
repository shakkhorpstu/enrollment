<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLevelSemesterColumnToRepeatCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repeat_course', function (Blueprint $table) {
            $table->integer('level')->after('student_id');
            $table->integer('semester')->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repeat_course', function (Blueprint $table) {
            //
        });
    }
}
