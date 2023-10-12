<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskIdentifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_identifications', function (Blueprint $table) {
            $table->id();
            $table->integer('id_objective')->nullable();
            $table->string('risk_compliance_sources')->nullable();
            $table->string('type')->nullable();
            $table->longText('risk_event')->nullable();
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
        Schema::dropIfExists('risk_identifications');
    }
}
