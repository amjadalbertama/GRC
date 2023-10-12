<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorebizactivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corebizactivity', function (Blueprint $table) {
            $table->id();
            $table->string('name_corebzact');
            $table->integer('org_id');
            $table->string('name_org');
            $table->string('lead_role');
            $table->string('description');
            $table->text('notes');
            $table->integer('status');
            $table->softDeletes();
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
        Schema::dropIfExists('corebizactivity');
    }
}
