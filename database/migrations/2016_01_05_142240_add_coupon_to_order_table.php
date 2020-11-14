<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->float('before_discount_price_total')->unsigned()->nullable();
            $table->float('net_price_total')->unsigned()->nullable();
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->float('coupon_discount_total')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->dropColumn([
                'before_discount_price_total',
                'net_price_total',
                'coupon_id',
                'coupon_discount_total'
            ]);
        });
    }
}
