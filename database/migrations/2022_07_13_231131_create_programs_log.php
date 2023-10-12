<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs_log', function (Blueprint $table) {
            $table->id();
            $table->integer("id_program")->nullable();
            $table->longText("reasons")->nullable();
            $table->longText("data_deleted")->nullable();
            $table->string("deleted_by", 255)->nullable();
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
        Schema::dropIfExists('programs_log');
    }
}
