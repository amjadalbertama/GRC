<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskImpactCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_impact_criteria', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->integer('area_count')->nullable();
            $table->integer('risk_app_id')->nullable();
            $table->integer('obj_id')->nullable();
            $table->tinyInteger('status');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('risk_impact_criteria');
    }
}
