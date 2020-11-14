<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('shipping_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
        });
        Schema::create('payment_statuses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
        });
        Schema::create('payment_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
        });
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
            $table->float('sub_total')->unsigned()->nullable();
            $table->integer('shipping_cost')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('order_status_id')->unsigned()->nullable();
            $table->integer('order_produce_status_id')->unsigned()->nullable();
            $table->integer('shipping_type_id')->unsigned();
            $table->integer('payment_status_id')->unsigned();
            $table->integer('payment_type_id')->unsigned();
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('order_status_id')
                ->references('id')->on('order_statuses')
                ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('order_produce_status_id')
                ->references('id')->on('order_produce_statuses')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('shipping_type_id')
                ->references('id')->on('shipping_types')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('payment_status_id')
                ->references('id')->on('payment_statuses')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('payment_type_id')
                ->references('id')->on('payment_types')
                ->onDelete('restrict')->onUpdate('cascade');
		});

        Schema::create('shipping_addresses', function(Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('full_name');
            $table->string('address');
            $table->string('building')->nullable();
            $table->string('district');
            $table->string('province');
            $table->string('zipcode');
            $table->string('phone');
            $table->string('email');
            $table->string('tracking_code')->default('')->nullable();
            $table->integer('order_id')->unsigned();
            $table->timestamps();
            $table->foreign('id')
                ->references('id')->on('orders')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('payments', function(Blueprint $table) {
            $table->increments('id');
            $table->float('total')->unsigned()->default(0);
            $table->dateTime('pay_on');
            $table->string('transaction_id')->nullable();
            $table->string('from_bank')->nullable();
            $table->string('to_bank')->nullable();
            $table->integer('order_id')->unsigned();
            $table->string('slip_upload')->nullable();
            $table->dateTime('confirmed_at');
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')->onUpdate('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shipping_types');
		Schema::dropIfExists('shipping_statuses');
		Schema::dropIfExists('payment_types');
		Schema::dropIfExists('payment_statuses');
		Schema::dropIfExists('orders');
		Schema::dropIfExists('shipping_addresses');
	}

}
