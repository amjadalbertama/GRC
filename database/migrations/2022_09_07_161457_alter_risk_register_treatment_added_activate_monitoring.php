<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterTreatmentAddedActivateMonitoring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_register_treatments')) {
            Schema::table('risk_register_treatments', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_register_treatments', 'is_monitoring')) {
                    $table->boolean('is_monitoring')->after('risk_treatment_residual_score')->default(0)->nullable();
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
        if (Schema::hasTable('risk_register_treatments')) {
            Schema::table('risk_register_treatments', function (Blueprint $table) {
                if (Schema::hasColumn('risk_register_treatments', 'is_monitoring')) {
                    $table->dropColumn('is_monitoring');
                }
            });
        }
    }
}
