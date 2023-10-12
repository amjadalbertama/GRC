<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIssuesChangeFieldType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('issue')) {
            Schema::table('issue', function (Blueprint $table) {
                if (Schema::hasColumn('issue', 'title')) {
                    $table->text('title')->change();
                }
                if (Schema::hasColumn('issue', 'ofi')) {
                    $table->text('ofi')->change();
                }
                if (Schema::hasColumn('issue', 'recomendation')) {
                    $table->text('recomendation')->change();
                }
                if (Schema::hasColumn('issue', 'followup_status')) {
                    $table->integer('followup_status')->change();
                }
                if (Schema::hasColumn('issue', 'category')) {
                    $table->integer('category')->change();
                }
                if (Schema::hasColumn('issue', 'information_source')) {
                    $table->integer('information_source')->change();
                }
                if (Schema::hasColumn('issue', 'type')) {
                    $table->integer('type')->change();
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
        if (Schema::hasTable('issue')) {
            Schema::table('issue', function (Blueprint $table) {
                if (Schema::hasColumn('issue', 'title')) {
                    $table->string('title')->change();
                }
                if (Schema::hasColumn('issue', 'ofi')) {
                    $table->string('ofi')->change();
                }
                if (Schema::hasColumn('issue', 'recomendation')) {
                    $table->string('recomendation')->change();
                }
                if (Schema::hasColumn('issue', 'followup_status')) {
                    $table->string('followup_status')->change();
                }
                if (Schema::hasColumn('issue', 'category')) {
                    $table->string('category')->change();
                }
                if (Schema::hasColumn('issue', 'information_source')) {
                    $table->string('information_source')->change();
                }
                if (Schema::hasColumn('issue', 'type')) {
                    $table->string('type')->change();
                }
            });
        }
    }
}
