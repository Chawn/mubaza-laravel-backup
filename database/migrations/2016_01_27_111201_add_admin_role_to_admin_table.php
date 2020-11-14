<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminRoleToAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function(Blueprint $table) {
            $table->smallInteger('admin_role_id')->nullable()->unsigned();

            $table->foreign('admin_role_id')
                ->references('id')
                ->on('admin_roles')
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
            $table->dropForeign('admins_admin_role_id_foreign');
            $table->dropColumn('admin_role_id');
        });
    }
}
