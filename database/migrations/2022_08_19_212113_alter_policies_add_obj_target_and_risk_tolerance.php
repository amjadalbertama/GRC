<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoliciesAddObjTargetAndRiskTolerance extends Migration
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
                if (!Schema::hasColumn('policies', 'id_objective')) {
                    $table->longText('id_objective')->after('id_org')->nullable();
                }
                if (!Schema::hasColumn('policies', 'target')) {
                    $table->longText('target')->after('id_objective')->nullable();
                }
                if (!Schema::hasColumn('policies', 'smart_objective')) {
                    $table->longText('smart_objective')->after('target')->nullable();
                }
                if (Schema::hasColumn('policies', 'tolerance')) {
                    $table->longText('tolerance')->change();
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
                if (Schema::hasColumn('policies', 'id_objective')) {
                    $table->dropColumn('id_objective');
                    $table->dropColumn('target');
                    $table->dropColumn('smart_objective');
                }
            });
        }
    }
}
