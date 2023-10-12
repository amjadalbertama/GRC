<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterChangePositionAttrLikelihoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('likelihood_criteria')) {
            Schema::table('likelihood_criteria', function (Blueprint $table) {
                if (Schema::hasColumn('likelihood_criteria', 'org_id')) {
                    DB::statement('ALTER TABLE likelihood_criteria MODIFY COLUMN org_id VARCHAR(255) AFTER period_id');
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
        if (Schema::hasTable('likelihood_criteria')) {
            Schema::table('likelihood_criteria', function (Blueprint $table) {
                if (Schema::hasColumn('likelihood_criteria', 'org_id')) {
                    DB::statement('ALTER TABLE likelihood_criteria MODIFY COLUMN org_id VARCHAR(255) AFTER updated_at');
                }
            });
        }
    }
}
