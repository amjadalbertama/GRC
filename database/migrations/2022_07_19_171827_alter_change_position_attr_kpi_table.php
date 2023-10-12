<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterChangePositionAttrKpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('kpi')) {
            Schema::table('kpi', function (Blueprint $table) {
                if (Schema::hasColumn('kpi', 'id_policies')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_policies VARCHAR(255) AFTER title');
                }
                if (Schema::hasColumn('kpi', 'id_org')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_org VARCHAR(255) AFTER id_policies');
                }
                if (Schema::hasColumn('kpi', 'id_policies_kpi')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_policies_kpi VARCHAR(255) AFTER id_org');
                }
                if (Schema::hasColumn('kpi', 'id_capabilities')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_capabilities VARCHAR(255) AFTER id_policies_kpi');
                }
                if (Schema::hasColumn('kpi', 'monitoring_status')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN monitoring_status VARCHAR(255) AFTER id_capabilities');
                }
                if (Schema::hasColumn('kpi', 'total')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN total VARCHAR(255) AFTER monitoring_status');
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
        if (Schema::hasTable('kpi')) {
            Schema::table('kpi', function (Blueprint $table) {
                if (Schema::hasColumn('kpi', 'id_policies')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_policies VARCHAR(255) AFTER updated_at');
                }
                if (Schema::hasColumn('kpi', 'id_org')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_org VARCHAR(255) AFTER id_policies');
                }
                if (Schema::hasColumn('kpi', 'id_policies_kpi')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_policies_kpi VARCHAR(255) AFTER id_org');
                }
                if (Schema::hasColumn('kpi', 'id_capabilities')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN id_capabilities VARCHAR(255) AFTER id_policies_kpi');
                }
                if (Schema::hasColumn('kpi', 'monitoring_status')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN monitoring_status VARCHAR(255) AFTER id_capabilities');
                }
                if (Schema::hasColumn('kpi', 'total')) {
                    DB::statement('ALTER TABLE kpi MODIFY COLUMN total VARCHAR(255) AFTER monitoring_status');
                }
            });
        }
    }
}
