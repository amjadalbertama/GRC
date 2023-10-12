<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDetailLikelihoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('details_likelihood')) {
            Schema::table('details_likelihood', function (Blueprint $table) {
                if (Schema::hasColumn('details_likelihood', 'fnum_frequency')) {
                    $table->string('fnum_frequency')->change()->nullable();
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
        //
    }
}
