<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_students', function (Blueprint $table) {
            $table->unsignedInteger('student_a_id');
            $table->unsignedInteger('student_b_id');

            $table->foreign('student_a_id')->references('id')->on('students');
            $table->foreign('student_b_id')->references('id')->on('students');

            $table->primary(['student_a_id', 'student_b_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_students');
    }
}
