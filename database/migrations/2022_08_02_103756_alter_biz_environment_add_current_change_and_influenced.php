<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBizEnvironmentAddCurrentChangeAndInfluenced extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('biz_environment')) {
            Schema::table('biz_environment', function (Blueprint $table) {
                if (!Schema::hasColumn('biz_environment', 'current_change')) {
                    $table->string('current_change')->after("type")->nullable();
                }
                if (!Schema::hasColumn('biz_environment', 'influenced_capabilities_process')) {
                    $table->longText('influenced_capabilities_process')->after("current_change")->nullable();
                }
                if (!Schema::hasColumn('biz_environment', 'influenced_capabilities_people')) {
                    $table->longText('influenced_capabilities_people')->after("influenced_capabilities_process")->nullable();
                }
                if (!Schema::hasColumn('biz_environment', 'influenced_capabilities_tools')) {
                    $table->longText('influenced_capabilities_tools')->after("influenced_capabilities_people")->nullable();
                }
                if (!Schema::hasColumn('biz_environment', 'influenced_capabilities_resources')) {
                    $table->longText('influenced_capabilities_resources')->after("influenced_capabilities_tools")->nullable();
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
                if (Schema::hasColumn('issue', 'current_change')) {
                    $table->dropColumn('current_change');
                }
                if (Schema::hasColumn('issue', 'influenced_capabilities_process')) {
                    $table->dropColumn('influenced_capabilities_process');
                }
                if (Schema::hasColumn('issue', 'influenced_capabilities_people')) {
                    $table->dropColumn('influenced_capabilities_people');
                }
                if (Schema::hasColumn('issue', 'influenced_capabilities_tools')) {
                    $table->dropColumn('influenced_capabilities_tools');
                }
                if (Schema::hasColumn('issue', 'influenced_capabilities_resources')) {
                    $table->dropColumn('influenced_capabilities_resources');
                }
            });
        }
    }
}
