<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAppetiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_appetite', function (Blueprint $table) {
            $table->id();
            $table->integer('id_objective')->nullable();
            $table->integer('org_id')->nullable();
            $table->longText('risk_capacity')->nullable();
            $table->longText('risk_appetite')->nullable();
            $table->longText('risk_tolerance')->nullable();
            $table->string('risk_limit')->nullable();
            $table->integer('id_risk_threshold')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('risk_appetite');
    }
}
