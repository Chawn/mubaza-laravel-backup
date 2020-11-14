<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBankAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_bank_accounts', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
            $table->string('no');
            $table->string('name');
            $table->string('branch');
            $table->string('bank_name');
			$table->timestamps();

            $table->foreign('id')->references('id')->on('users')
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
		Schema::dropIfExists('user_bank_accounts');
	}

}
