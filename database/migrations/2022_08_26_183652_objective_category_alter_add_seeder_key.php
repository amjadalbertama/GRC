<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ObjectiveCategoryAlterAddSeederKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('objectegory')) {
            Schema::table('objectegory', function (Blueprint $table) {
                if (!Schema::hasColumn('objectegory', 'seed_key')) {
                    $table->integer('seed_key')->after('notes')->nullable();
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
        if (Schema::hasTable('objectegory')) {
            Schema::table('objectegory', function (Blueprint $table) {
                if (Schema::hasColumn('objectegory', 'seed_key')) {
                    $table->dropColumn('seed_key');
                }
            });
        }
    }
}
