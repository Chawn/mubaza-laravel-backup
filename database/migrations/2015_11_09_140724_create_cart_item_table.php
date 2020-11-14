<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cart_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('campaign_product_id')->unsigned();
            $table->integer('product_sku_id')->unsigned();
            $table->integer('qty')->unsigned();
            $table->integer('affiliate_id')->unsigned()->nullable();
            $table->bigInteger('click_stat_id')->unsigned()->nullable();
            $table->dateTime('affiliate_expired_at')->nullable();

            $table->foreign('campaign_id')
                ->references('id')
                ->on('campaigns')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('campaign_product_id')
                ->references('id')
                ->on('campaign_products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('product_sku_id')
                ->references('id')
                ->on('product_skus')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('affiliate_id')
                ->references('id')
                ->on('affiliates')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('click_stat_id')
                ->references('id')
                ->on('click_stats')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
