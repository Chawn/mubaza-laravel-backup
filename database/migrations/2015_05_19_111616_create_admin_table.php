<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

		Schema::create('admins', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('full_name')->nullable();
            $table->string('detail')->nullale()->default('');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->string('sex', 10)->default('0');
            $table->string('avatar')->nullable();

            $table->rememberToken();
            $table->timestamps();
		});

        Schema::create('role_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('roles');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('role_admin');
	}

}
