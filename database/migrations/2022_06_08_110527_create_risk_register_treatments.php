<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisterTreatments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_register_treatments', function (Blueprint $table) {
            $table->id();
            $table->integer("id_risk_register")->nullable();
            $table->string("risk_treatment_strategy")->nullable();
            $table->double("risk_treatment_residual_likelihood")->nullable();
            $table->double("risk_treatment_residual_likelihood_score")->nullable();
            $table->double("risk_treatment_residual_impact")->nullable();
            $table->double("risk_treatment_residual_impact_score")->nullable();
            $table->double("risk_treatment_residual_score")->nullable();
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
        Schema::dropIfExists('risk_register_treatments');
    }
}
