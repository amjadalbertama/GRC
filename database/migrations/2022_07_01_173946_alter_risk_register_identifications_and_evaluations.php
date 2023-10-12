<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterIdentificationsAndEvaluations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_register_identifications')) {
            Schema::table('risk_register_identifications', function (Blueprint $table) {
                if (Schema::hasColumn('risk_register_identifications', 'kri_lower')) {
                    $table->string('kri_lower', 255)->change();
                    $table->string('kri_upper', 255)->change();
                }
            });
        }
        if (Schema::hasTable('risk_register_evaluations')) {
            Schema::table('risk_register_evaluations', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_register_evaluations', 'capability')) {
                    $table->boolean('capability')->after("risk_evaluation_benefit")->default(0)->nullable();
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
        if (Schema::hasTable('risk_register_identifications')) {
            Schema::table('risk_register_identifications', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_register_identifications', 'kri_lower')) {
                    $table->double('kri_lower')->change();
                    $table->double('kri_upper')->change();
                }
            });
        }
        if (Schema::hasTable('risk_register_evaluations')) {
            Schema::table('risk_register_evaluations', function (Blueprint $table) {
                if (Schema::hasColumn('risk_register_evaluations', 'capability')) {
                    $table->dropColumn('capability');
                }
            });
        }
    }
}
