<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['General', 'Special'])->nullable();
            $table->integer('id_org')->nullable();
            $table->integer('id_period')->nullable();
            $table->string('source')->nullable();
            $table->integer('id_source')->nullable();
            $table->date('target_date')->nullable();
            $table->integer('status')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit');
    }
}
