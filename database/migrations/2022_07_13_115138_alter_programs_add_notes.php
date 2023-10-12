<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProgramsAddNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('programs')) {
            Schema::table('programs', function (Blueprint $table) {
                if (!Schema::hasColumn('programs', 'notes')) {
                    $table->longText('notes')->after("status")->nullable();
                    $table->integer('id_type_controls')->after("notes")->nullable();
                    $table->longText('controls')->after("id_type_controls")->nullable();
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
        if (Schema::hasTable('programs')) {
            Schema::table('programs', function (Blueprint $table) {
                if (Schema::hasColumn('programs', 'notes')) {
                    $table->dropColumn('notes');
                    $table->dropColumn('id_type_controls');
                    $table->dropColumn('controls');
                }
            });
        }
    }
}
