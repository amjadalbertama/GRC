<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeRatingComplianceAddSeedkeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('type_rating_compliance')) {
            Schema::table('type_rating_compliance', function (Blueprint $table) {
                if (!Schema::hasColumn('type_rating_compliance', 'seed_key')) {
                    $table->integer('seed_key')->after("style_rating")->nullable();
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
        if (Schema::hasTable('type_rating_compliance')) {
            Schema::table('type_rating_compliance', function (Blueprint $table) {
                if (Schema::hasColumn('type_rating_compliance', 'seed_key')) {
                    $table->dropColumn('seed_key');
                }
            });
        }
    }
}
