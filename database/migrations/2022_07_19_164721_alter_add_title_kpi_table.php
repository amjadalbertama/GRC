<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterAddTitleKpiTable extends Migration
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
                if (!Schema::hasColumn('kpi', 'title')) {
                    $table->string('title')->after("id")->nullable();
                }
                if (!Schema::hasColumn('kpi', 'percentage')) {
                    $table->string('percentage')->after("id_policies_kpi")->nullable();
                }
                if (!Schema::hasColumn('kpi', 'metric')) {
                    $table->string('metric')->after("percentage")->nullable();
                }
                if (!Schema::hasColumn('kpi', 'period')) {
                    $table->string('period')->after("metric")->nullable();
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
                if (Schema::hasColumn('kpi', 'title')) {
                    $table->dropColumn('title');
                }
                if (Schema::hasColumn('kpi', 'percentage')) {
                    $table->dropColumn('percentage');
                }
                if (Schema::hasColumn('kpi', 'metric')) {
                    $table->dropColumn('metric');
                }
                if (Schema::hasColumn('kpi', 'period')) {
                    $table->dropColumn('period');
                }
            });
        }
    }
}
