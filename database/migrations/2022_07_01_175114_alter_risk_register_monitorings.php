<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterMonitorings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_register_monitorings')) {
            Schema::table('risk_register_monitorings', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_register_monitorings', 'risk_monitoring_actual_likelihood')) {
                    $table->double('risk_monitoring_actual_likelihood')->after("risk_update_changes")->nullable();
                    $table->double('risk_monitoring_actual_likelihood_score')->after("risk_monitoring_actual_likelihood")->nullable();
                    $table->double('risk_monitoring_actual_impact')->after("risk_monitoring_actual_likelihood_score")->nullable();
                    $table->double('risk_monitoring_actual_impact_score')->after("risk_monitoring_actual_impact")->nullable();
                    $table->double('risk_monitoring_actual_score')->after("risk_monitoring_actual_impact_score")->nullable();
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
        if (Schema::hasTable('risk_register_monitorings')) {
            Schema::table('risk_register_monitorings', function (Blueprint $table) {
                if (Schema::hasColumn('risk_register_monitorings', 'risk_monitoring_actual_likelihood')) {
                    $table->dropColumn('risk_monitoring_actual_likelihood');
                    $table->dropColumn('risk_monitoring_actual_likelihood_score');
                    $table->dropColumn('risk_monitoring_actual_impact');
                    $table->dropColumn('risk_monitoring_actual_impact_score');
                    $table->dropColumn('risk_monitoring_actual_score');
                }
            });
        }
    }
}
