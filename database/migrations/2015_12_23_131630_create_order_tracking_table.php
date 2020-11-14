<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_trackings', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('order_tracking_type_id')->unsigned();
            $table->string('detail')->nullable();
            $table->integer('order_id')->unsigned();
            $table->timestamps();

            $table->foreign('order_tracking_type_id')->references('id')->on('order_tracking_types')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_trackings');
    }
}
