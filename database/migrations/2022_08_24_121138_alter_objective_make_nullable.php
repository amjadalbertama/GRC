<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterObjectiveMakeNullable extends Migration
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
                if (Schema::hasColumn('objective', 'smart_objectives')) {
                    $table->text('smart_objectives')->nullable()->change();
                }
                if (Schema::hasColumn('objective', 'id_category')) {
                    $table->integer('id_category')->nullable()->change();
                }
                if (Schema::hasColumn('objective', 'id_organization')) {
                    $table->integer('id_organization')->nullable()->change();
                }
                if (Schema::hasColumn('objective', 'id_period')) {
                    $table->integer('id_period')->nullable()->change();
                }
                if (Schema::hasColumn('objective', 'criteria')) {
                    $table->longText('criteria')->nullable()->change();
                }
                if (Schema::hasColumn('objective', 'notes')) {
                    $table->longText('notes')->nullable()->change();
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
        // Not need to rollback, because it is necessary to nullable
        // if you really want to back it again, use it from below
        
        // if (Schema::hasTable('objective')) {
        //     Schema::table('objective', function (Blueprint $table) {
        //         if (Schema::hasColumn('objective', 'smart_objectives')) {
        //             $table->text('smart_objectives')->nullable(false)->change();
        //         }
        //         if (Schema::hasColumn('objective', 'id_category')) {
        //             $table->integer('id_category')->nullable(false)->change();
        //         }
        //         if (Schema::hasColumn('objective', 'id_organization')) {
        //             $table->integer('id_organization')->nullable(false)->change();
        //         }
        //         if (Schema::hasColumn('objective', 'id_period')) {
        //             $table->integer('id_period')->nullable(false)->change();
        //         }
        //         if (Schema::hasColumn('objective', 'criteria')) {
        //             $table->longText('criteria')->nullable(false)->change();
        //         }
        //         if (Schema::hasColumn('objective', 'notes')) {
        //             $table->longText('notes')->nullable(false)->change();
        //         }
        //     });
        // }
    }
}
