<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->integer("id_risk_register")->nullable();
            $table->longText("program_title")->nullable();
            $table->longText("actions")->nullable();
            $table->integer("id_type")->nullable();
            $table->double("budget")->nullable();
            $table->longText("output")->nullable();
            $table->text("capability_checklist")->nullable();
            $table->float("cba_ratio")->nullable();
            $table->date("schedule")->nullable();
            $table->string("pic", 255)->nullable();
            $table->integer("status")->nullable();
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
        Schema::dropIfExists('programs');
    }
}
