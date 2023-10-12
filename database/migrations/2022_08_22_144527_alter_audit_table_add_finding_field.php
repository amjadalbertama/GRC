<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAuditTableAddFindingField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('audit')) {
            Schema::table('audit', function (Blueprint $table) {
                if (!Schema::hasColumn('audit', 'finding')) {
                    $table->integer('finding')->after('id_period')->nullable();
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
        if (Schema::hasTable('audit')) {
            Schema::table('audit', function (Blueprint $table) {
                if (Schema::hasColumn('audit', 'finding')) {
                    $table->dropColumn('finding');
                }
            });
        }
    }
}
