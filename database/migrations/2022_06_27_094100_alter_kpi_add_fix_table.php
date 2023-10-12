<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKpiAddFixTable extends Migration
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
                if (!Schema::hasColumn('kpi', 'matric')) {
                    $table->string('matric')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'monitoring_status')) {
                    $table->string('monitoring_status')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'percentage')) {
                    $table->integer('percentage')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'target')) {
                    $table->integer('target')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'business_outcome')) {
                    $table->string('business_outcome')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'id_policies')) {
                    $table->integer('id_policies')->nullable();
                }
                if (!Schema::hasColumn('kpi', 'policy')) {
                    $table->string('policy')->nullable();
                }
                if (Schema::hasColumn('kpi', 'description')) {
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('kpi', 'owner')) {
                    $table->dropColumn('owner');
                }
                if (Schema::hasColumn('kpi', 'date')) {
                    $table->dropColumn('date');
                }
                if (Schema::hasColumn('kpi', 'status')) {
                    $table->dropColumn('status');
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
    }
}
