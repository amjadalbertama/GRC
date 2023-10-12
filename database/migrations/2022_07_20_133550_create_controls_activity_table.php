<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlsActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls_activity', function (Blueprint $table) {
            $table->id();
            $table->longText('activity_control')->nullable();
            $table->integer('id_control')->nullable();
            $table->integer('id_kri')->nullable();
            $table->integer('id_issue')->nullable();
            $table->integer('id_control_issue')->nullable();
            $table->integer('threshold_lower')->nullable();
            $table->integer('threshold_upper')->nullable();
            $table->enum('activity_effectiveness', ['Effective','Not Effective'])->nullable();
            $table->enum('activity_status', ['Within Threshold','Out Of Threshold'])->nullable();
            $table->string('activity_indicator')->nullable();
            $table->longText('activity_issue')->nullable();
            $table->longText('activity_issue_root_cause')->nullable();
            $table->longText('activity_action')->nullable();
            $table->longText('activity_result')->nullable();
            $table->longText('activity_kci')->nullable();
            $table->enum('activity_type', ['Detective','Preventive','Responsive'])->nullable();
            $table->longText('notes')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('controls_activity');
    }
}
