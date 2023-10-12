<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterControlsActivityAddIdKciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('controls_activity')) {
            Schema::table('controls_activity', function (Blueprint $table) {
                if (!Schema::hasColumn('controls_activity', 'id_kci')) {
                    $table->integer('id_kci')->after('id_control_issue')->nullable();
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
        if (Schema::hasTable('controls_activity')) {
            Schema::table('controls_activity', function (Blueprint $table) {
                if (Schema::hasColumn('controls_activity', 'id_kci')) {
                    $table->dropColumn('id_kci');
                }
            });
        }
    }
}
