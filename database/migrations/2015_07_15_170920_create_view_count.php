<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCount extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('view_counts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('path_id')->unsigned();
			$table->integer('session_id')->unsigned()->nullable();
			$table->timestamps();

			$table->foreign('path_id')->references('id')->on('view_paths')
				->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('session_id')->references('id')->on('view_sessions')
				->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('view_counts');
	}

}
