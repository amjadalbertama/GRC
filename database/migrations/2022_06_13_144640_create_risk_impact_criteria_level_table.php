<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskImpactCriteriaLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_impact_criteria_level', function (Blueprint $table) {
            $table->id();
            $table->integer('impact_id')->nullable();
            $table->string('impact_level')->nullable();
            $table->string('impact_value')->nullable();
            $table->string('impact_level_color')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('risk_impact_criteria_level');
    }
}
