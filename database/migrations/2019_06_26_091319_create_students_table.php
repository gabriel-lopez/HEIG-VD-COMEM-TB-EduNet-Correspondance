<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');

            $table->string('login')->unique();
            $table->string('password');

            $table->string('name');
            $table->string('surname');
            $table->enum('sex', ['male', 'female']);
            $table->date('birthdate');

            $table->text('description')->nullable();

            $table->boolean('available')->default(true);

            $table->unsignedInteger('scheduled_educational_activity_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('scheduled_educational_activity_id')->references('id')->on('scheduled_educational_activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
