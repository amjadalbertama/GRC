<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskRegisterEvaluationAcceptRejectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cekDb = DB::table("risk_register_evaluation_accept_reject")->get();

        if (sizeof($cekDb) == 0) {
            $dataVal = [
                ["name" => "Take The Risk",],
                ["name" => "Avoid The Risk",],
            ];
            $insVal = DB::table("risk_register_evaluation_accept_reject")->insert($dataVal);
        }
    }
}
