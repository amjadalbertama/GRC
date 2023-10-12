<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterTreatmentStrategyChangeTitle extends Migration
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
                if (Schema::hasColumn('risk_register_treatment_strategy', 'program_title')) {
                    $table->longText('program_title')->change();
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
                if (Schema::hasColumn('risk_register_treatment_strategy', 'program_title')) {
                    $table->string('program_title', 255)->change();
                }
            });
        }
    }
}
