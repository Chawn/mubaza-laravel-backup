<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_name');
            $table->string('coupon_code')->unique();
            $table->text('coupon_detail')->nullable();
            $table->float('coupon_discount_number')->unsigned();
            $table->enum('coupon_discount_type', ['price', 'percent']);
            $table->enum('coupon_condition_at_least_price_flag', ['yes', 'no']);
            $table->enum('coupon_condition_end_date_flag', ['yes', 'no']);
            $table->enum('coupon_condition_max_use_per_user_flag', ['yes', 'no']);
            $table->enum('coupon_condition_max_user_flag', ['yes', 'no']);
            $table->float('coupon_condition_at_least_price')->unsigned()->nullable();
            $table->dateTime('coupon_condition_end_date');
            $table->integer('coupon_condition_max_use_per_user')->unsigned();
            $table->integer('coupon_condition_max_user')->unsigned();
            $table->enum('status', ['enable', 'draft', 'disable']);
            $table->timestamps();
            $table->softDeletes();
        });
//        Schema::table('coupons', function (Blueprint $table) {
//            $sql = "ALTER TABLE coupons CHANGE coupon_code coupon_code VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;";
//            DB::statement($sql);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupons');
    }
}
