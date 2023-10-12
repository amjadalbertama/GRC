<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeIssueAddSeedKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('type_issue')) {
            Schema::table('type_issue', function (Blueprint $table) {
                if (!Schema::hasColumn('type_issue', 'seed_key')) {
                    $table->integer('seed_key')->after("name_type_issue")->nullable();
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
        if (Schema::hasTable('type_issue')) {
            Schema::table('type_issue', function (Blueprint $table) {
                if (Schema::hasColumn('type_issue', 'seed_key')) {
                    $table->dropColumn('seed_key');
                }
            });
        }
    }
}
