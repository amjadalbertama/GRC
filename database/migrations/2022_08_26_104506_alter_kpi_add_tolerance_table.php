<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKpiAddToleranceTable extends Migration
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
                if (!Schema::hasColumn('kpi', 'tolerance')) {
                    $table->string('tolerance')->after('monitoring_status')->nullable();
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
        if (Schema::hasTable('kpi')) {
            Schema::table('kpi', function (Blueprint $table) {
                if (Schema::hasColumn('kpi', 'tolerance')) {
                    $table->dropColumn('tolerance');
                }
            });
        }
    }
}
