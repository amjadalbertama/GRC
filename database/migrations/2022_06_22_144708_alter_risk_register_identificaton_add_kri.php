<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterIdentificatonAddKri extends Migration
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
                if (Schema::hasColumn('risk_register_identifications', 'risk_causes_risk_indicator_internal')) {
                    $table->boolean('is_kri')->after('risk_causes_external')->default(0);
                    $table->text('kri')->after('is_kri')->nullable();
                    $table->double('kri_lower')->after('kri')->nullable();
                    $table->double('kri_upper')->after('kri_lower')->nullable();
                    $table->dropColumn('risk_causes_risk_indicator_internal');
                    $table->dropColumn('risk_causes_internal_lower');
                    $table->dropColumn('risk_causes_internal_upper');
                    $table->dropColumn('risk_causes_risk_indicator_external');
                    $table->dropColumn('risk_causes_external_lower');
                    $table->dropColumn('risk_causes_external_upper');
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
                if (!Schema::hasColumn('risk_register_identifications', 'risk_causes_risk_indicator_internal')) {
                    $table->dropColumn('is_kri');
                    $table->dropColumn('kri');
                    $table->dropColumn('kri_lower');
                    $table->dropColumn('kri_upper');
                    $table->longText('risk_causes_risk_indicator_internal')->after("risk_causes_external")->nullable();
                    $table->double('risk_causes_internal_lower')->after("risk_causes_risk_indicator_internal")->nullable();
                    $table->double('risk_causes_internal_upper')->after("risk_causes_internal_lower")->nullable();
                    $table->longText('risk_causes_risk_indicator_external')->after("risk_causes_internal_upper")->nullable();
                    $table->double('risk_causes_external_lower')->after("risk_causes_risk_indicator_external")->nullable();
                    $table->double('risk_causes_external_upper')->after("risk_causes_external_lower")->nullable();
                }
            });
        }
    }
}
