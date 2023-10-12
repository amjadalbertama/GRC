<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddnewIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('issue')) {
            Schema::table('issue', function (Blueprint $table) {
                if (!Schema::hasColumn('issue', 'title')) {
                    $table->string('title')->after("id")->nullable();
                }
                if (!Schema::hasColumn('issue', 'id_kci')) {
                    $table->integer('id_kci')->after("status")->nullable();
                }
                if (!Schema::hasColumn('issue', 'id_kri')) {
                    $table->integer('id_kri')->after("id_kci")->nullable();
                }
                if (!Schema::hasColumn('issue', 'id_kpi')) {
                    $table->integer('id_kpi')->after("id_kci")->nullable();
                }
                if (!Schema::hasColumn('issue', 'id_control_activity')) {
                    $table->integer('id_control_activity')->after("id_kpi")->nullable();
                }
                if (!Schema::hasColumn('issue', 'id_risk_register')) {
                    $table->integer('id_risk_register')->after("id_control_activity")->nullable();
                }
                if (!Schema::hasColumn('issue', 'type')) {
                    $table->string('type')->after("id_risk_register")->nullable();
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
        if (Schema::hasTable('issue')) {
            Schema::table('issue', function (Blueprint $table) {
                if (Schema::hasColumn('issue', 'title')) {
                    $table->dropColumn('title');
                }
                if (Schema::hasColumn('issue', 'id_kci')) {
                    $table->dropColumn('id_kci');
                }
                if (Schema::hasColumn('issue', 'id_kri')) {
                    $table->dropColumn('id_kri');
                }
                if (Schema::hasColumn('issue', 'id_kpi')) {
                    $table->dropColumn('id_kpi');
                }
                if (Schema::hasColumn('issue', 'id_control_activity')) {
                    $table->dropColumn('id_control_activity');
                }
                if (Schema::hasColumn('issue', 'id_risk_register')) {
                    $table->dropColumn('id_risk_register');
                }
                if (Schema::hasColumn('issue', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
}
