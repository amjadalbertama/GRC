<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpactCriteriaAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_impact_criteria_area', function (Blueprint $table) {
            $table->id();
            $table->integer('impact_id')->nullable();
            $table->string('impact_area')->nullable();
            $table->string('impact_level')->nullable();
            $table->string('impact_area_value_min')->nullable();
            $table->string('impact_area_value_max')->nullable();
            $table->string('impact_area_value_symbols')->nullable();
            $table->string('impact_area_description')->nullable();
            $table->string('impact_area_type')->nullable();
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
        Schema::dropIfExists('risk_impact_criteria_area');
    }
}
