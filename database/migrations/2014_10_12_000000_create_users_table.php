<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('detail');
        });

        Schema::create('user_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail');

        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name')->nullable();
            $table->string('detail')->nullable()->default('');
            $table->string('username')->unique()->nullable();
            $table->string('url')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->string('sex', 10)->default('m');
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('provider');
            $table->string('provider_id');
            $table->boolean('is_social')->default(false);
            $table->boolean('is_designer')->default(false);
            $table->boolean('is_affiliate')->default(false);
            $table->boolean('show_phone')->default(false);
            $table->boolean('show_email')->default(true);
            $table->integer('user_status_id')->unsigned();
            $table->integer('user_role_id')->unsigned();
            $table->string('remark')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_status_id')
                ->references('id')->on('user_statuses')
                ->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('address')->nullable()->default('');
            $table->string('district')->nullable()->default('');
            $table->string('building')->nullable()->default('');
            $table->string('province')->nullable()->default('');
            $table->string('zipcode')->nullable()->default('');
            $table->string('phone')->nullable()->default('');
            $table->date('birthday')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            $table->string('line_id')->nullable();
            $table->string('line_qr')->nullable();
            $table->string('picture')->nullable()->default('');
            $table->primary('id');
            $table->timestamps();
            $table->foreign('id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('user_options', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->smallInteger('show_full_name')->nullable()->default(1);
            $table->smallInteger('show_sex')->nullable()->default(0);
            $table->smallInteger('show_birthday')->nullable()->default(0);
            $table->smallInteger('show_email')->nullable()->default(0);
            $table->smallInteger('show_address')->nullable()->default(0);
            $table->smallInteger('show_phone')->nullable()->default(0);
            $table->smallInteger('show_hit_count')->nullable()->default(1);
            $table->primary('id');
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
        Schema::dropIfExists('user_options');
        Schema::dropIfExists('user_profiles');
        Schema::dropIfExists('users');
    }

}
