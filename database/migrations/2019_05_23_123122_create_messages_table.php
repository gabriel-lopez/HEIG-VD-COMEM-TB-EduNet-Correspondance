<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('subject');
            $table->text('content');

            $table->morphs('sender');
            $table->morphs('recipient');

            $table->enum('status', ['draft', 'moderation_sender', 'moderation_recipient', 'new', 'read'])->default('moderation_sender');

            $table->boolean('is_correspondence_request')->default(false);
            $table->boolean('is_correspondence_request_answer')->default(false);

            $table->boolean('deleted_for_sender')->default(false);
            $table->boolean('deleted_for_recipient')->default(false);

            $table->unsignedInteger('answer_of')->nullable();

            $table->dateTime('sent_at')->nullable();

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
        Schema::dropIfExists('messages');
    }
}
