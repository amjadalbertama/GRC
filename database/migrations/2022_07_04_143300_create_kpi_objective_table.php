<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiObjectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_objective', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kpi')->nullable();
            $table->integer('id_objective')->nullable();
            $table->string('kpi')->nullable();
            $table->integer('percentage')->nullable();
            $table->string('metric')->nullable();
            $table->string('period')->nullable();
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
        Schema::dropIfExists('kpi_objective');
    }
}
