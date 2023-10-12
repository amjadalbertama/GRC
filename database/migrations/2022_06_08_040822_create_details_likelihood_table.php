<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsLikelihoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_likelihood', function (Blueprint $table) {
            $table->id();
            $table->integer('fnum_frequency')->nullable();
            $table->string('range_frequency')->nullable();
            $table->string('type_frequency')->nullable();
            $table->string('likelihood')->nullable();
            $table->string('likelihood_id')->nullable();
            $table->integer('range_start')->nullable();
            $table->integer('range_end')->nullable();
            $table->string('name_level')->nullable();
            $table->integer('score_level')->nullable();
            $table->string('code_warna')->nullable();
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
        Schema::dropIfExists('details_likelihood');
    }
}
