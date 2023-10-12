<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRegisterIdentifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_register_identifications', function (Blueprint $table) {
            $table->id();
            $table->integer("id_risk_register")->nullable();
            $table->longText("risk_event_event")->nullable();
            $table->string("risk_event_category", 255)->nullable();
            $table->longText("risk_causes_internal")->nullable();
            $table->longText("risk_causes_external")->nullable();
            $table->longText("risk_causes_risk_indicator_internal")->nullable();
            $table->string("risk_causes_internal_lower")->nullable();
            $table->string("risk_causes_internal_upper")->nullable();
            $table->longText("risk_causes_risk_indicator_external")->nullable();
            $table->string("risk_causes_external_lower")->nullable();
            $table->string("risk_causes_external_upper")->nullable();
            $table->longText("risk_impact_description")->nullable();
            $table->longText("risk_impact_areas")->nullable();
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
        Schema::dropIfExists('risk_register_identifications');
    }
}
