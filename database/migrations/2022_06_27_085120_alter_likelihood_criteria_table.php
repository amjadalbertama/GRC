<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLikelihoodCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('likelihood_criteria')) {
            Schema::table('likelihood_criteria', function (Blueprint $table) {
                if (Schema::hasColumn('likelihood_criteria', 'type')) {
                    $table->string('notes')->after('type')->nullable();
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
    }
}
