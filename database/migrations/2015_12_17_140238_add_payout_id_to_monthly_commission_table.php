<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayoutIdToMonthlyCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_commissions', function(Blueprint $table) {
            $table->integer('payout_id')->nullable()->unsigned()->after('monthly_commission_status_id');

            $table->foreign('payout_id')->references('id')->on('payouts')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_commissions', function(Blueprint $table) {
            $table->dropForeign('monthly_commissions_payout_id_foreign');
            $table->dropColumn('payout_id');
        });
    }
}
