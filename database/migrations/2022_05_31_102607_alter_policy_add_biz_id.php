<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolicyAddBizId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('policies')) {
            Schema::table('policies', function (Blueprint $table) {
                if (!Schema::hasColumn('policies', 'id_bizenv')) {
                    $table->integer('id_bizact')->nullable();
                    $table->integer('id_bizenv')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('policies')) {
            Schema::table('policies', function (Blueprint $table) {
                if (Schema::hasColumn('policies', 'id_bizenv')) {
                    $table->dropColumn('id_bizact');
                    $table->dropColumn('id_bizenv');
                }
            });
        }
    }
}
