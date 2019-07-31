<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOldProfileDrawingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_profile_drawings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('student_id')->nullable()->unique();

            $table->unsignedInteger('character_id');
            $table->unsignedInteger('animal_id');
            $table->unsignedInteger('window_id');
            $table->unsignedInteger('painting_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('character_id')->references('id')->on('old_profile_drawing_images');
            $table->foreign('animal_id')->references('id')->on('old_profile_drawing_images');
            $table->foreign('window_id')->references('id')->on('old_profile_drawing_images');
            $table->foreign('painting_id')->references('id')->on('old_profile_drawing_images');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_profile_drawings');
    }
}
