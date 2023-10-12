<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskRegisterTreatmentType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cekDb = DB::table("treatment_types")->get();

        if (sizeof($cekDb) == 0) {
            $dataVal = [
                ["name_treatment" => "Threat Mitigation",],
                ["name_treatment" => "Opportunity Expoitation",],
                ["name_treatment" => "Requirement Fulfillment",],
            ];
            $insVal = DB::table("treatment_types")->insert($dataVal);
        }
    }
}
