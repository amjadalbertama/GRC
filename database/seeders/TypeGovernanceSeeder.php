<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeGovernanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'type_governance';
        $cekDb = DB::table($table)->get();

        if (sizeof($cekDb) == 0) {
            DB::table($table)
                ->insert([
                    'id' => 1,
                    'environment' => 'Desired',
                    'policies' => 'Positive',
                    'risk_identification' => 'Opportunity',
                ]);
            DB::table($table)
                ->insert([
                    'id' => 2,
                    'environment' => 'Not Desired',
                    'policies' => 'Negative',
                    'risk_identification' => 'Threat',
                ]);
            DB::table($table)
                ->insert([
                    'id' => 3,
                    'environment' => 'Requirement',
                    'policies' => 'Compliance',
                    'risk_identification' => 'Requirement',
                ]);
        }
    }
}
