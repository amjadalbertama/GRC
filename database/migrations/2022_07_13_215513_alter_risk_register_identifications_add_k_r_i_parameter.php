<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskRegisterIdentificationsAddKRIParameter extends Migration
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
                if (!Schema::hasColumn('risk_register_identifications', 'kri_parameter')) {
                    $table->string('kri_parameter', 255)->after("kri_upper")->nullable();
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
                if (Schema::hasColumn('risk_register_identifications', 'kri_parameter')) {
                    $table->dropColumn('kri_parameter', 255);
                }
            });
        }
    }
}
