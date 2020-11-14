<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_statuses', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
		});

		Schema::create('order_produce_statuses', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('order_statuses');
		Schema::dropIfExists('order_produce_statuses');
	}

}
