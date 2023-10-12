<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKpiAddOrgIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('kpi')) {
            Schema::table('kpi', function (Blueprint $table) {
                if (!Schema::hasColumn('kpi', 'id_org')) {
                    $table->integer('id_org')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'id_policies_kpi')) {
                    $table->integer('id_policies_kpi')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'id_capabilities')) {
                    $table->integer('id_capabilities')->nullable();
                }
                if (Schema::hasColumn('kpi', 'name_org')) {
                    $table->dropColumn('name_org');
                }
                if (Schema::hasColumn('kpi', 'policy')) {
                    $table->dropColumn('policy');
                }
                if (Schema::hasColumn('kpi', 'title')) {
                    $table->dropColumn('title');
                }
                if (Schema::hasColumn('kpi', 'matric')) {
                    $table->dropColumn('matric');
                }
                if (Schema::hasColumn('kpi', 'business_outcome')) {
                    $table->dropColumn('business_outcome');
                }
                if (Schema::hasColumn('kpi', 'percentage')) {
                    $table->dropColumn('percentage');
                }
                if (Schema::hasColumn('kpi', 'target')) {
                    $table->dropColumn('target');
                }
                if (Schema::hasColumn('kpi', 'policy_id')) {
                    $table->dropColumn('policy_id');
                }
                if (Schema::hasColumn('kpi', 'matrix')) {
                    $table->dropColumn('matrix');
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
        //
    }
}
