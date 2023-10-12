<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIssueInformationsAddSeedKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('issue_information_source')) {
            Schema::table('issue_information_source', function (Blueprint $table) {
                if (!Schema::hasColumn('issue_information_source', 'seed_key')) {
                    $table->integer('seed_key')->after("name_information_source")->nullable();
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
        if (Schema::hasTable('issue_information_source')) {
            Schema::table('issue_information_source', function (Blueprint $table) {
                if (Schema::hasColumn('issue_information_source', 'seed_key')) {
                    $table->dropColumn('seed_key');
                }
            });
        }
    }
}
