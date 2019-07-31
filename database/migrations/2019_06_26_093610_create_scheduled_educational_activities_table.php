<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledEducationalActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_educational_activities', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('canton_id');

            $table->dateTime('authorized_until')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('canton_id')->references('id')->on('cantons');
            $table->foreign('level_id')->references('id')->on('scheduled_educational_activity_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_educational_activities');
    }
}
