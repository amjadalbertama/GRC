<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeGovernanceAddRiskIdentification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('type_governance')) {
            Schema::table('type_governance', function (Blueprint $table) {
                if (!Schema::hasColumn('type_governance', 'risk_identification')) {
                    $table->longText('risk_identification')->after('policies')->nullable();
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
