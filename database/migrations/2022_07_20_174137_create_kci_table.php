<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kci', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->integer("id_control_activity")->nullable();
            $table->integer("id_org")->nullable();
            $table->integer("threshold_upper")->nullable();
            $table->integer("threshold_lower")->nullable();
            $table->string("monitoring_status")->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kci');
    }
}
