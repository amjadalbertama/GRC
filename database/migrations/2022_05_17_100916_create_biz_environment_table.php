<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBizEnvironmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biz_environment', function (Blueprint $table) {
            $table->id();
            $table->string('name_environment')->nullable();
            $table->integer('period')->nullable();
            $table->integer('id_organization')->nullable();
            $table->integer('business_activity')->nullable();
            $table->integer('type')->nullable();
            $table->integer('effect')->nullable();
            $table->integer('status')->nullable();
            $table->string('source')->nullable();
            $table->longText('description')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('biz_environment');
    }
}
