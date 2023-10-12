<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskAppetiteeAddOrgId extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_appetite')) {
            Schema::table('risk_appetite', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_appetite', 'org_id')) {
                    $table->integer('org_id')->after('id_objective')->nullable();
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
