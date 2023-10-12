<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kri', function (Blueprint $table) {
            $table->id();
            $table->string('kri')->nullable();
            $table->string('kri_parameter')->nullable();
            $table->string('kri_lower')->nullable();
            $table->string('kri_upper')->nullable();
            $table->string('obj_id')->nullable();
            $table->string('id_risk_register')->nullable();
            $table->enum('monitor_status', ['Within limit', 'Out of limit']);
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
        Schema::dropIfExists('kri');
    }
}
