<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplianceStatusFulfilledSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'compliance_status_fulfilled';
        $cekDb = DB::table($table)->get();

        $dataInfoSource = [
            [
                'name_status' => 'Not Fulfilled',
                'style_status' => 'text-danger',
                'position' => 0,
            ],
            [
                'name_status' => 'On Progress Fulfilled',
                'style_status' => 'text-warning',
                'position' => 1,
            ],
            [
                'name_status' => 'Partly Fulfilled',
                'style_status' => 'text-success',
                'position' => 2,
            ],
            [
                'name_status' => 'Fully Fulfilled',
                'style_status' => 'text-primary',
                'position' => 3,
            ],

        ];

        if (sizeof($cekDb) == 0) {
            // echo "masuk sini gan";
            DB::table($table)->insert($dataInfoSource);
        } else {
            foreach ($dataInfoSource as $info) {
                $getInfo = json_decode(json_encode(DB::table($table)->where("position", $info["position"])->first()), true);

                if (isset($getInfo["name_status"])) {
                    // echo "Ngapdet";
                    DB::table($table)->where("position", $info["position"])->update($info);
                } else {
                    // echo "Ngasup";
                    DB::table($table)->insert($info);
                }
                if (isset($getInfo["style_status"])) {
                    // echo "Ngapdet";
                    DB::table($table)->where("position", $info["position"])->update($info);
                } else {
                    // echo "Ngasup";
                    DB::table($table)->insert($info);
                }
            }
        }
    }
}
