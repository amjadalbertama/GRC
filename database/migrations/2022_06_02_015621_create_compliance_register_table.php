<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplianceRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_register', function (Blueprint $table) {
            $table->id();
            $table->string('risk_id')->nullable();
            $table->longText('external_regulation')->nullable();
            $table->longText('internal_regulation')->nullable();
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->string('execution_time_limit')->nullable();
            $table->string('executor')->nullable();
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
        Schema::dropIfExists('compliance_register');
    }
}
