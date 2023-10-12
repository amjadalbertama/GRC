<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterTreatmentStrategyAddIdRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_register_treatment_strategy')) {
            Schema::table('risk_register_treatment_strategy', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_register_treatment_strategy', 'id_risk_register')) {
                    $table->double('id_risk_register')->after("id")->nullable();
                }
                if (Schema::hasColumn('risk_register_treatment_strategy', 'risk_treatment_strategy')) {
                    $table->longText('risk_treatment_strategy')->change();
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
        if (Schema::hasTable('risk_register_treatment_strategy')) {
            Schema::table('risk_register_treatment_strategy', function (Blueprint $table) {
                if (Schema::hasColumn('risk_register_treatment_strategy', 'id_risk_register')) {
                    $table->dropColumn('id_risk_register');
                }
                if (Schema::hasColumn('risk_register_treatment_strategy', 'risk_treatment_strategy')) {
                    $table->string('risk_treatment_strategy', 255)->change();
                }
            });
        }
    }
}
