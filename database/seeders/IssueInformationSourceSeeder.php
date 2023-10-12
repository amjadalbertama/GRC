<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssueInformationSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'issue_information_source';
        $cekDb = DB::table($table)->get();

        $dataInfoSource = [
            [
                'name_information_source' => 'Control Detective',
                'seed_key' => 0,
            ],
            [
                'name_information_source' => 'Control Prefentive',
                'seed_key' => 1,
            ],
            [
                'name_information_source' => 'Control Responsive',
                'seed_key' => 2,
            ],
            [
                'name_information_source' => 'Risk Monitoring Update',
                'seed_key' => 3,
            ],
            [
                'name_information_source' => 'Risk Monitoring Tolerance Status',
                'seed_key' => 4,
            ],
            [
                'name_information_source' => 'Risk Monitoring Tolerance Alarp',
                'seed_key' => 5,
            ],
            [
                'name_information_source' => 'KPI',
                'seed_key' => 6,
            ],
            [
                'name_information_source' => 'KCI',
                'seed_key' => 7,
            ],
            [
                'name_information_source' => 'KRI',
                'seed_key' => 8,
            ],
            [
                'name_information_source' => 'Internal Control',
                'seed_key' => 9,
            ],

        ];

        if (sizeof($cekDb) == 0) {
            // echo "masuk sini gan";
            DB::table($table)->insert($dataInfoSource);
        } else {
            foreach ($dataInfoSource as $info) {
                $getInfo = json_decode(json_encode(DB::table($table)->where("seed_key", $info["seed_key"])->first()), true);

                if (isset($getInfo["name_information_source"])) {
                    // echo "Ngapdet";
                    DB::table($table)->where("seed_key", $info["seed_key"])->update($info);
                } else {
                    // echo "Ngasup";
                    DB::table($table)->insert($info);
                }
            }
        }
    }
}
