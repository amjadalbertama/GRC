<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatusMappingAddAlert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('status_mapping')) {
            Schema::table('status_mapping', function (Blueprint $table) {
                if (!Schema::hasColumn('status_mapping', 'alert_style')) {
                    $table->string('alert_style', 255)->nullable();
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
        if (Schema::hasTable('status_mapping')) {
            Schema::table('status_mapping', function (Blueprint $table) {
                if (Schema::hasColumn('status_mapping', 'alert_style')) {
                    $table->dropColumn('alert_style');
                }
            });
        }
    }
}
