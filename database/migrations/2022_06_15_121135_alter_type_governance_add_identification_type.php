<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeGovernanceAddIdentificationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('type_governance')) {
            Schema::table('type_governance', function (Blueprint $table) {
                if (!Schema::hasColumn('type_governance', 'identification_type')) {
                    $table->string('identification_type')->nullable();
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
        if (Schema::hasTable('type_governance')) {
            Schema::table('type_governance', function (Blueprint $table) {
                if (Schema::hasColumn('type_governance', 'identification_type')) {
                    $table->dropColumn('identification_type');
                }
            });
        }
    }
}
