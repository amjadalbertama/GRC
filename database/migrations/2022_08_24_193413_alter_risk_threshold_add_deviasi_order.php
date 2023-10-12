<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiskThresholdAddDeviasiOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_threshold')) {
            Schema::table('risk_threshold', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_threshold', 'deviasi_order')) {
                    $table->text('deviasi_order')->after('deviasi')->nullable();
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
        if (Schema::hasTable('risk_threshold')) {
            Schema::table('risk_threshold', function (Blueprint $table) {
                if (Schema::hasColumn('risk_threshold', 'deviasi_order')) {
                    $table->dropColumn('deviasi_order');
                }
            });
        }
    }
}
