<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminStatusIdToAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function(Blueprint $table) {
            $table->smallInteger('admin_status_id')->nullable()->unsigned();

            $table->foreign('admin_status_id')
                ->references('id')
                ->on('admin_statuses')
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
        Schema::table('admins', function(Blueprint $table) {
            $table->dropForeign('admins_admin_status_id_foreign');
            $table->dropColumn('admin_status_id');
        });
    }
}
