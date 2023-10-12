<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBizEnvAddTrendAnalysis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('biz_environment')) {
            Schema::table('biz_environment', function (Blueprint $table) {
                if (!Schema::hasColumn('biz_environment', 'trend_analysis')) {
                    $table->longText('trend_analysis')->after('source')->nullable();
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
