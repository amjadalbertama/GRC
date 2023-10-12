<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_registers', function (Blueprint $table) {
            $table->id();
            $table->integer("id_objective")->nullable();
            $table->integer("id_risk_identification")->nullable();
            $table->string("types")->nullable();
            $table->string("status")->nullable();
            $table->string("objective_category")->nullable();
            $table->string("smart_objective")->nullable();
            $table->integer("id_org")->nullable();
            $table->string("owner")->nullable();
            $table->longText("additional_description")->nullable();
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
        Schema::dropIfExists('risk_registers');
    }
}
