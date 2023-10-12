<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiPeriodsEndTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_periods_end', function (Blueprint $table) {
            $table->id();
            $table->integer('kpi_id')->nullable();
            $table->integer('target_period_end')->nullable();
            $table->integer('actual_period_end')->nullable();
            $table->integer('score_period_end')->nullable();
            $table->integer('end_period_end')->nullable();
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
        Schema::dropIfExists('kpi_periods_end');
    }
}
