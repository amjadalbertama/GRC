<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterObjectiveAddAchievement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('objective')) {
            Schema::table('objective', function (Blueprint $table) {
                if (!Schema::hasColumn('objective', 'achievement')) {
                    $table->boolean('achievement')->after("notes")->default(0)->nullable();
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
        if (Schema::hasTable('objective')) {
            Schema::table('objective', function (Blueprint $table) {
                if (Schema::hasColumn('objective', 'achievement')) {
                    $table->dropColumn('achievement');
                }
            });
        }
    }
}
