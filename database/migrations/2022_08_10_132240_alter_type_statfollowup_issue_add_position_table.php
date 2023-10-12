<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeStatfollowupIssueAddPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('type_statfollowup_issue')) {
            Schema::table('type_statfollowup_issue', function (Blueprint $table) {
                if (!Schema::hasColumn('type_statfollowup_issue', 'position')) {
                    $table->integer('position')->after("style_status")->nullable();
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
        if (Schema::hasTable('type_statfollowup_issue')) {
            Schema::table('type_statfollowup_issue', function (Blueprint $table) {
                if (Schema::hasColumn('type_statfollowup_issue', 'position')) {
                    $table->dropColumn('position');
                }
            });
        }
    }
}
