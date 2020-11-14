<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->smallInteger('qty')->unsigned();
            $table->integer('price')->unsigned();
            $table->float('creator_commission')->unsigned()->default(0.00);
            $table->float('affiliate_commission')->unsigned()->default(0.00);
            $table->integer('campaign_id')->unsigned();
            $table->integer('campaign_product_id')->unsigned();
            $table->integer('product_sku_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->boolean('produced')->default(false);
            $table->dateTime('produced_at')->nullable();
            $table->integer('affiliate_id')->unsigned()->nullable();
            $table->bigInteger('click_stat_id')->unsigned()->nullable();
            $table->float('affiliate_rate')->unsigned()->default(0.00);
            $table->float('creator_rate')->unsigned()->default(0.00);
            $table->smallInteger('commission_status_id')->unsigned()->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('campaign_product_id')
                ->references('id')->on('campaign_products')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('product_sku_id')
                ->references('id')->on('product_skus')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('affiliate_id')
                ->references('id')->on('affiliates')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('click_stat_id')
                ->references('id')->on('click_stats')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('commission_status_id')
                ->references('id')->on('commission_statuses')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
