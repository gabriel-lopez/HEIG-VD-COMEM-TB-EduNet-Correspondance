<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOldProfileDrawingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_profile_drawing_images', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->enum('type', ['character', 'animal', 'window', 'painting']);
            $table->string('filename');
            $table->boolean('default')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_profile_drawing_images');
    }
}
