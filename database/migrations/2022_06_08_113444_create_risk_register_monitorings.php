<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisterMonitorings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_register_monitorings', function (Blueprint $table) {
            $table->id();
            $table->integer("id_risk_register")->nullable();
            $table->longText("risk_monitoring_indicator")->nullable();
            $table->string("risk_monitoring_lower")->nullable();
            $table->string("risk_monitoring_upper")->nullable();
            $table->integer("risk_monitoring_status")->nullable();
            $table->integer("risk_tolerance_status")->nullable();
            $table->integer("risk_tolerance_alarp")->nullable();
            $table->integer("risk_update_changes")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_register_monitorings');
    }
}
