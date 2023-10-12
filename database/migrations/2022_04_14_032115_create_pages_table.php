<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page')->nullable(); // Organization
            $table->string("deskripsi")->nullable(); // Desc
            $table->string('page_group')->nullable(); // Governence
            $table->string('permission')->nullable(); // organization
            $table->boolean('is_active')->default(1);
            $table->integer('position')->default(1);
            $table->integer('position_group')->default(1);
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
        Schema::dropIfExists('pages');
    }
}
