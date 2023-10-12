<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterComplianceRegisterTable extends Migration
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
                if (Schema::hasColumn('compliance_register', 'external_regulation')) {
                    $table->string('compliance')->nullable();
                    $table->dropColumn('external_regulation');
                }
                if (Schema::hasColumn('compliance_register', 'internal_regulation')) {
                    $table->string('rating')->nullable();
                    $table->dropColumn('internal_regulation');
                }
                if (Schema::hasColumn('compliance_register', 'category')) {
                    $table->string('organization')->nullable();
                    $table->dropColumn('category');
                }
                if (Schema::hasColumn('compliance_register', 'description')) {
                    $table->integer('objective_id')->nullable();
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('compliance_register', 'execution_time_limit')) {
                    $table->dropColumn('execution_time_limit');
                }
                if (Schema::hasColumn('compliance_register', 'executor')) {
                    $table->dropColumn('executor');
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
        if (Schema::hasTable('compliance_register')) {
            Schema::table('compliance_register', function (Blueprint $table) {
                if (Schema::hasColumn('compliance_register', 'external_regulation')) {
                    $table->dropColumn('exeternal_regulation');
                    $table->string('compliance')->change();
                }
                if (Schema::hasColumn('compliance_register', 'internal_regulation')) {
                    $table->dropColumn('internal_regulation');
                    $table->string('rating')->change();
                }
                if (Schema::hasColumn('compliance_register', 'category')) {
                    $table->dropColumn('category');
                    $table->string('organization')->change();
                }
                if (Schema::hasColumn('compliance_register', 'description')) {
                    $table->dropColumn('description');
                    $table->string('objective_id')->change();
                }
                if (Schema::hasColumn('compliance_register', 'execution_time_limit')) {
                    $table->dropColumn('execution_time_limit');
                }
                if (Schema::hasColumn('compliance_register', 'executor')) {
                    $table->dropColumn('executor');
                }
            });
        }
    }
}
