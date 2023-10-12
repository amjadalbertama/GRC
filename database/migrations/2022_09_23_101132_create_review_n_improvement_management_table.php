<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewNImprovementManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_n_improvement_management', function (Blueprint $table) {
            $table->id();
            $table->integer('id_review')->nullable();
            $table->integer('id_monev')->nullable();
            $table->integer('id_audit')->nullable();
            $table->integer('id_program')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('review_n_improvement_management');
    }
}
