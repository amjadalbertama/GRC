<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesKpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies_kpi', function (Blueprint $table) {
            $table->id();
            $table->integer("id_policies")->nullable();
            $table->string("indicators")->nullable();
            $table->string("metric")->nullable();
            $table->integer("period")->nullable();
            $table->double("percentage")->nullable();
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
        Schema::dropIfExists('policies_kpi');
    }
}
