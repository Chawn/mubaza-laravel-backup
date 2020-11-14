<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail');
            $table->boolean('is_active')->default(0);
        });
        Schema::create('campaign_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail');
            $table->boolean('is_active')->default(true);
        });
        Schema::create('campaign_categories', function(Blueprint $table) {
           $table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('cover_image')->nullable();
        });
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 40)->nullable();
            $table->text('description')->nullable();
            $table->string('url', 100)->unique()->nullable();
            $table->smallInteger('back_cover')->default('0');
            $table->dateTime('end')->nullable();
            $table->boolean('both_print')->default(false);
            $table->boolean('is_recommended')->default(0);
            $table->boolean('is_hot')->default(0);
            $table->integer('campaign_category_id')->unsigned()->nullable();
            $table->integer('campaign_type_id')->unsigned()->nullable();
            $table->integer('campaign_status_id')->unsigned()->nullable();
            $table->string('image_front');
            $table->string('image_back');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('remark')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('campaign_type_id')
                ->references('id')->on('campaign_types')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('campaign_status_id')
                ->references('id')->on('campaign_statuses')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('campaign_category_id')
                ->references('id')->on('campaign_categories')
                ->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('campaign_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
            $table->integer('product_color_id')->unsigned();
            $table->integer('sell_price')->unsigned();
            $table->integer('min_price')->unsigned();
            $table->boolean('back_cover')->default(0);
            $table->string('image_front');
            $table->string('image_front_thmb')->nullable();
            $table->string('image_back');
            $table->string('image_back_thmb')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_primary')->default(false);

            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('product_color_id')
                ->references('id')->on('product_colors')
                ->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('campaign_tag', function (Blueprint $table) {
            $table->integer('campaign_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->nullable()->index();

            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::dropIfExists('campaign_tag');
        Schema::dropIfExists('seller_pickups');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('campaign_types');
        Schema::dropIfExists('campaign_statuses');
    }

}
