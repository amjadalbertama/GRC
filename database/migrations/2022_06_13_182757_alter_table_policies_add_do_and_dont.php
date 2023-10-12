<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePoliciesAddDoAndDont extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('policies')) {
            Schema::table('policies', function (Blueprint $table) {
                if (!Schema::hasColumn('policies', 'dos')) {
                    $table->integer('id_category')->nullable();
                    $table->longText('dos')->nullable();
                    $table->longText('donts')->nullable();
                }
                if (Schema::hasColumn('policies', 'capacity')) {
                    $table->longText('capacity')->change();
                    $table->longText('appetite')->change();
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
        if (Schema::hasTable('policies')) {
            Schema::table('policies', function (Blueprint $table) {
                if (Schema::hasColumn('policies', 'dos')) {
                    $table->dropColumn('dos');
                    $table->dropColumn('donts');
                    $table->string('capacity')->change();
                    $table->string('appetite')->change();
                }
            });
        }
    }
}
