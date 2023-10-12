<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterComplianceCategoryTable extends Migration
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
                if (Schema::hasColumn('compliance_category', 'org_id')) {
                    $table->dropColumn('org_id');
                }
                if (!Schema::hasColumn('compliance_category', 'type')) {
                    $table->enum('type', ['Mandatory', 'Voluntary'])->after("description")->nullable();
                }
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
                if (!Schema::hasColumn('compliance_category', 'org_id')) {
                    $table->integer('org_id')->after('name')->nullable();
                }
                if (Schema::hasColumn('compliance_category', 'type')) {
                    $table->dropColumn('type');
                }
                if (Schema::hasColumn('compliance_category', 'position')) {
                    $table->dropColumn('position');
                }
            });
        }
    }
}
