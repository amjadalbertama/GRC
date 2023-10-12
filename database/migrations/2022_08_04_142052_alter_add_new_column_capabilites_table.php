<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddNewColumnCapabilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('capabilities')) {
            Schema::table('capabilities', function (Blueprint $table) {
                $table->text('business_planning')->after('description')->nullable();
                $table->text('business_operation')->after('business_planning')->nullable();
                $table->text('business_evaluation')->after('business_operation')->nullable();
                $table->text('business_improvement')->after('business_evaluation')->nullable();
                $table->text('business_effectiveness')->after('business_improvement')->nullable();
                $table->integer('personel_number')->after('business_effectiveness')->nullable();
                $table->integer('personel_level')->after('personel_number')->nullable();
                $table->integer('personel_productivity')->after('personel_level')->nullable();
                $table->text('tooltech_tools_installed')->after('personel_productivity')->nullable();
                $table->text('tooltech_tech_installed')->after('tooltech_tools_installed')->nullable();
                $table->text('tooltech_capacity')->after('tooltech_tech_installed')->nullable();
                $table->text('resource_financial')->after('tooltech_capacity')->nullable();
                $table->text('resource_non_financial')->after('resource_financial')->nullable();
                $table->text('resource_adequacy_allocated')->after('resource_non_financial')->nullable();
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
        if (Schema::hasTable('controls_activity')) {
            Schema::table('controls_activity', function (Blueprint $table) {
                $table->dropColumn('business_planning');
                $table->dropColumn('business_operation');
                $table->dropColumn('business_evaluation');
                $table->dropColumn('business_improvement');
                $table->dropColumn('business_effectiveness');
                $table->dropColumn('personel_number');
                $table->dropColumn('personel_level');
                $table->dropColumn('personel_productivity');
                $table->dropColumn('tooltech_tools_installed');
                $table->dropColumn('tooltech_tech_installed');
                $table->dropColumn('tooltech_capacity');
                $table->dropColumn('resource_financial');
                $table->dropColumn('resource_non_financial');
                $table->dropColumn('resource_adequacy_allocated');
            });
        }
    }
}
