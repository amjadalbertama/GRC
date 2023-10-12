<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplianceObligationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_obligations', function (Blueprint $table) {
            $table->id();
            $table->integer('id_org')->nullable();
            $table->string('name_obligations')->nullable();
            $table->string('compliance_source')->nullable();
            $table->string('rating')->nullable();
            $table->string('name_org')->nullable();
            $table->string('compliance_owner')->nullable();
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
        Schema::dropIfExists('compliance_obligations');
    }
}
