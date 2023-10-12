<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterChangetypeComplianceRegisterTable extends Migration
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
                if (Schema::hasColumn('compliance_register', 'risk_id')) {
                    $table->integer('risk_id')->change();
                }
                if (Schema::hasColumn('compliance_register', 'rating')) {
                    $table->integer('rating')->change();
                }
                if (Schema::hasColumn('compliance_register', 'organization')) {
                    $table->integer('organization')->change();
                }
                if (Schema::hasColumn('compliance_register', 'description_obj')) {
                    $table->dropColumn('description_obj');
                }
                if (Schema::hasColumn('compliance_register', 'description_risk_event')) {
                    $table->dropColumn('description_risk_event');
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
                if (Schema::hasColumn('compliance_register', 'risk_id')) {
                    $table->string('risk_id')->change();
                }
                if (Schema::hasColumn('compliance_register', 'rating')) {
                    $table->string('rating')->change();
                }
                if (Schema::hasColumn('compliance_register', 'organization')) {
                    $table->string('organization')->change();
                }
                if (!Schema::hasColumn('compliance_register', 'description_obj')) {
                    $table->string('description_obj')->nullable()->after('rating');
                }
                if (!Schema::hasColumn('compliance_register', 'description_risk_event')) {
                    $table->string('description_risk_event')->nullable()->after('organization');
                }
            });
        }
    }
}
