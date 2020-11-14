<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('report_types', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('detail');
        });

		Schema::create('reports', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('report_type_id')->unsigned()->nullable();
            $table->text('detail')->nullable();
            $table->integer('reporter_id')->unsigned()->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->smallInteger('is_opened');
			$table->timestamps();

            $table->foreign('reporter_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('campaign_id')->references('id')->on('campaigns')
                ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('report_type_id')->references('id')->on('report_types')
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
		Schema::dropIfExists('reports');
		Schema::dropIfExists('report_types');
	}

}
