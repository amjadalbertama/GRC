<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisterEvaluations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_register_evaluations', function (Blueprint $table) {
            $table->id();
            $table->integer("id_risk_register")->nullable();
            $table->string("risk_evaluation_level")->nullable();
            $table->string("risk_evaluation_appetite")->nullable();
            $table->longText("risk_evaluation_benefit")->nullable();
            $table->integer("risk_evaluation_accept_reject")->nullable();
            $table->integer("risk_evaluation_priority")->nullable();
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
        Schema::dropIfExists('risk_register_evaluations');
    }
}
