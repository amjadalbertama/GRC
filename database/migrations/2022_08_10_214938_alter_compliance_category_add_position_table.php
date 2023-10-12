<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterComplianceCategoryAddPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('compliance_category')) {
            Schema::table('compliance_category', function (Blueprint $table) {
                if (!Schema::hasColumn('compliance_category', 'position')) {
                    $table->integer('position')->after("type")->nullable();
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
        if (Schema::hasTable('compliance_category')) {
            Schema::table('compliance_category', function (Blueprint $table) {
                if (Schema::hasColumn('compliance_category', 'position')) {
                    $table->dropColumn('position');
                }
            });
        }
    }
}
