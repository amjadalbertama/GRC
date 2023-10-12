<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterComplianceStatusFulfilledAddPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('compliance_status_fulfilled')) {
            Schema::table('compliance_status_fulfilled', function (Blueprint $table) {
                if (!Schema::hasColumn('compliance_status_fulfilled', 'position')) {
                    $table->integer('position')->after("style_status")->nullable();
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
        if (Schema::hasTable('compliance_status_fulfilled')) {
            Schema::table('compliance_status_fulfilled', function (Blueprint $table) {
                if (Schema::hasColumn('compliance_status_fulfilled', 'position')) {
                    $table->dropColumn('position');
                }
            });
        }
    }
}
