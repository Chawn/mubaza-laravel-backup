<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_commission_statuses', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('detail');
        });

        Schema::create('monthly_commissions', function(Blueprint $table) {
            $table->increments('id');
            $table->double('total')->unsigned()->default(0);
            $table->integer('affiliate_qty')->unsigned()->default(0);
            $table->integer('creator_qty')->unsigned()->default(0);
            $table->double('affiliate_sell')->unsigned()->default(0);
            $table->double('creator_sell')->unsigned()->default(0);
            $table->double('affiliate_commission')->unsigned()->default(0);
            $table->double('creator_commission')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->smallInteger('monthly_commission_status_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('monthly_commission_status_id')->references('id')->on('monthly_commission_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_commissions');
        Schema::dropIfExists('monthly_commission_statuses');
    }
}
