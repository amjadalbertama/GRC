<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterComplianceRegisterAddFixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('compliance_register')) {
            Schema::table('compliance_register', function (Blueprint $table) {
                if (!Schema::hasColumn('compliance_register', 'description_obj')) {
                    $table->string('description_obj')->nullable();
                }
                if (!Schema::hasColumn('compliance_register', 'description_risk_event')) {
                    $table->string('description_risk_event')->nullable();
                }
                if (!Schema::hasColumn('compliance_register', 'compliance_owner')) {
                    $table->string('compliance_owner')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
