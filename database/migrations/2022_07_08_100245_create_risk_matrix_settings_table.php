<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskMatrixSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_risk_matrix_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('risk_matrix_id')->nullable();
            $table->longText('likelihood_scale')->nullable();
            $table->longText('likelihood_scale_threshold')->nullable();
            $table->longText('likelihood_scale_tolerance')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_risk_matrix_settings');
    }
}
