<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisterAnalysis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_register_analysis', function (Blueprint $table) {
            $table->id();
            $table->integer("id_risk_register")->nullable();
            $table->double("inherent_risk_likelihood")->nullable();
            $table->double("inherent_risk_likelihood_score")->nullable();
            $table->double("inherent_risk_impact")->nullable();
            $table->double("inherent_risk_impact_score")->nullable();
            $table->double("inherent_risk_score")->nullable();
            $table->longText("risk_existing_control_exploit")->nullable();
            $table->longText("risk_existing_control_preventif")->nullable();
            $table->longText("risk_existing_control_detective")->nullable();
            $table->longText("risk_existing_control_responsive")->nullable();
            $table->string("risk_existing_control_exploit_effectiveness")->nullable();
            $table->string("risk_existing_control_exploit_kci")->nullable();
            $table->string("risk_existing_control_preventif_effectiveness")->nullable();
            $table->string("risk_existing_control_preventif_kci")->nullable();
            $table->string("risk_existing_control_detective_effectiveness")->nullable();
            $table->string("risk_existing_control_detective_kci")->nullable();
            $table->string("risk_existing_control_responsive_effectiveness")->nullable();
            $table->string("risk_existing_control_responsive_kci")->nullable();
            $table->double("current_risk_likelihood")->nullable();
            $table->double("current_risk_likelihood_score")->nullable();
            $table->double("current_risk_impact")->nullable();
            $table->double("current_risk_impact_score")->nullable();
            $table->double("current_risk_score")->nullable();
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
        Schema::dropIfExists('risk_register_analysis');
    }
}
