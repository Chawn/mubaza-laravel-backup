<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClickStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_stats', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method');
            $table->string('source')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('agent')->nullable();
            $table->string('landing_page');
            $table->string('query_string')->nullable();
            $table->integer('affiliate_id')->unsigned()->nullable;
            $table->dateTime('request_time');
            $table->timestamps();

            $table->foreign('affiliate_id')
                ->references('id')->on('affiliates')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('click_stats');
    }
}
