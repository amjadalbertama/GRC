<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRiskRegisterAddLikelihoodAndImpact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_registers')) {
            Schema::table('risk_registers', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_registers', 'id_impact')) {
                    $table->integer('id_impact')->after('additional_description')->nullable();
                    $table->integer('id_likelihood')->after('id_impact')->nullable();
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
        if (Schema::hasTable('risk_registers')) {
            Schema::table('risk_registers', function (Blueprint $table) {
                if (Schema::hasColumn('risk_registers', 'id_impact')) {
                    $table->dropColumn('id_impact');
                    $table->dropColumn('id_likelihood');
                }
            });
        }
    }
}
