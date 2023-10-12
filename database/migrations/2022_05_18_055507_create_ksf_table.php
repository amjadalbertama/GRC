<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKsfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ksf', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('owner');
            $table->string('name_org');
            $table->date('date');
            $table->enum('status', ['Created', 'Reviewed', 'Recheck', 'Resubmitted', 'Approved', 'Delete request']);
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
        Schema::dropIfExists('ksf');
    }
}
