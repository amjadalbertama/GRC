<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLikelihoodAddOrgIdTable extends Migration
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
                if (!Schema::hasColumn('likelihood_criteria', 'org_id')) {
                    $table->integer('org_id')->nullable();
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
