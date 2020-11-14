<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleImageSizeCampaignProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_products', function(Blueprint $table) {
            $table->string('image_front_small')->nullable()->after('image_front');
            $table->string('image_front_medium')->nullable()->after('image_front_small');
            $table->string('image_front_large')->nullable()->after('image_front_medium');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_products', function(Blueprint $table) {
            $table->dropColumn([
                'image_front_small',
                'image_front_medium',
                'image_front_large'
            ]);
        });
    }
}
