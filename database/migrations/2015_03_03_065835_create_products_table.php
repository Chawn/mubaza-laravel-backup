<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('detail')->nullable();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price')->unsigned();
            $table->float('one_side_price')->unsigned();
//            $table->float('two_side_price')->unsigned();
            $table->float('max_price')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('product_outlines', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('outline_width')->unsigned()->default(100);;
            $table->integer('outline_height')->unsigned()->default(100);;
            $table->integer('outline_left')->unsigned()->default(20);
            $table->integer('outline_top')->unsigned()->default(20);
            $table->primary('id');
            $table->foreign('id')
                ->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('product_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color');
            $table->string('color_name');
            $table->string('image_front');
            $table->string('image_front_thmb')->nullable();
            $table->string('image_back');
            $table->string('image_back_thmb')->nullable();
            $table->boolean('primary')->default(false);
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::create('product_skus', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('size', 5);
            $table->integer('qty')->default(0);
            $table->integer('product_color_id')->unsigned();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product_color_id')
                ->references('id')->on('product_colors')
                ->onDelete('restrict')->onUpdate('cascade');

        });

        Schema::create('product_descriptions', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->longText('full_detail')->nullable();
            $table->integer('s_height')->unsigned()->default(0);
            $table->integer('s_width')->unsigned()->default(0);
            $table->integer('m_height')->unsigned()->default(0);
            $table->integer('m_width')->unsigned()->default(0);
            $table->integer('l_height')->unsigned()->default(0);
            $table->integer('l_width')->unsigned()->default(0);
            $table->integer('xl_height')->unsigned()->default(0);
            $table->integer('xl_width')->unsigned()->default(0);
            $table->integer('xxl_height')->unsigned()->default(0);
            $table->integer('xxl_width')->unsigned()->default(0);
            $table->integer('product_id')->unsigned()->default(0);
            $table->foreign('id')
                ->references('id')->on('products')
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
        Schema::dropIfExists('product_descriptions');
        Schema::dropIfExists('product_outlines');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_skus');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('product_types');
        Schema::dropIfExists('categories');
    }

}
