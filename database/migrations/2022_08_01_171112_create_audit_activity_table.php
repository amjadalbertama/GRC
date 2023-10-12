<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_activity', function (Blueprint $table) {
            $table->id();
            $table->integer('id_audit')->nullable();
            $table->longText('audit_finding')->nullable();
            $table->longText('ofi')->nullable();
            $table->longText('recommendation')->nullable();
            $table->date('target_date')->nullable();
            $table->integer('status')->nullable();
            $table->integer('follow_up_status')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('audit_activity');
    }
}
