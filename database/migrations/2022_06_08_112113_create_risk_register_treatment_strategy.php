<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisterTreatmentStrategy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_register_treatment_strategy', function (Blueprint $table) {
            $table->id();
            $table->integer("id_treatment")->nullable();
            $table->integer("id_type")->nullable();
            $table->string("program_title")->nullable();
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
        Schema::dropIfExists('risk_register_treatment_strategy');
    }
}
