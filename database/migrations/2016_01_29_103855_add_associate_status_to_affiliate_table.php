<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssociateStatusToAffiliateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliates', function(Blueprint $table) {
            $table->smallInteger('associate_status_id')->unsigned()->nullable();
            $table->foreign('associate_status_id')
                ->references('id')
                ->on('associate_statuses')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliates', function(Blueprint $table) {
            $table->dropForeign('affiliates_associate_status_id_foreign');
            $table->dropColumn('associate_status_id');
        });
    }
}
