<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message');
            $table->smallInteger('notification_type_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('notification_type_id')
                ->references('id')
                ->on('notification_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
