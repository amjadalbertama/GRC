<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRiskRegisterChangeSmartObjToRiskEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_registers')) {
            Schema::table('risk_registers', function (Blueprint $table) {
                if (Schema::hasColumn('risk_registers', 'smart_objective')) {
                    $table->renameColumn('smart_objective', 'risk_event');
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
        if (Schema::hasTable('risk_registers')) {
            Schema::table('risk_registers', function (Blueprint $table) {
                if (Schema::hasColumn('risk_registers', 'risk_event')) {
                    $table->renameColumn('risk_event', 'smart_objective');
                }
            });
        }
    }
}
