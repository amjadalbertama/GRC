<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeIssueCategoryAddPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('issue_category')) {
            Schema::table('issue_category', function (Blueprint $table) {
                if (!Schema::hasColumn('issue_category', 'position')) {
                    $table->integer('position')->after("name_category_issue")->nullable();
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
        if (Schema::hasTable('issue_category')) {
            Schema::table('issue_category', function (Blueprint $table) {
                if (Schema::hasColumn('issue_category', 'position')) {
                    $table->dropColumn('position');
                }
            });
        }
    }
}
