<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue', function (Blueprint $table) {
            $table->id();
            $table->integer("id_org")->nullable();
            $table->string("followup_status")->nullable();
            $table->string("ofi")->nullable();
            $table->string("recomendation")->nullable();
            $table->string("category")->nullable();
            $table->date("target_date")->nullable();
            $table->string("information_source")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('issue');
    }
}
