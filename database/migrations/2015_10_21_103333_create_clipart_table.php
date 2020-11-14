<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClipartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clip_art_categories', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('detail')->nullable();
        });
        Schema::create('clip_arts', function(Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('clip_art_category_id')->unsigned();
            $table->string('original');
            $table->string('thumbnail');
            $table->boolean('active')->default(true);

            $table->foreign('clip_art_category_id')->references('id')->on('clip_art_categories')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clip_arts');
        Schema::dropIfExists('clip_art_categories');
    }
}
