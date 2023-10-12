<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskRegisterStatusMapping extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = "risk_register_status_mapping";
        $cekDb = DB::table($tables)->get();

        if (sizeof($cekDb) == 0) {
            $dataVal = [
                [
                    "status" => "Draft",
                    "styles" => "text-secondary",
                ],
                [
                    "status" => "Active",
                    "styles" => "text-success",
                ],
                [
                    "status" => "Closed",
                    "styles" => "text-body",
                ],
                [
                    "status" => "Occured",
                    "styles" => "text-body",
                ],
                [
                    "status" => "Escalated",
                    "styles" => "text-body",
                ],
                [
                    "status" => "Expired",
                    "styles" => "text-warning",
                ],
                [
                    "status" => "Deleted",
                    "styles" => "text-danger",
                ],
                [
                    "status" => "Rejected",
                    "styles" => "text-danger",
                ],
            ];
            $insVal = DB::table($tables)->insert($dataVal);
        }
    }
}
