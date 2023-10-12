<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('kpi_id')->nullable();
            $table->string('periods')->nullable();
            $table->integer('target')->nullable();
            $table->integer('actual')->nullable();
            $table->integer('score')->nullable();
            $table->integer('end')->nullable();
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
        Schema::dropIfExists('kpi_periods');
    }
}
