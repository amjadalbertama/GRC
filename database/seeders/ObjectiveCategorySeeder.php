<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObjectiveCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'objectegory';
        $cekDb = DB::table($table)->get();

        $dataSeed = [
            [
                "id_organization" => 0,
                "title" => "Strategic",
                "description" => "Strategic Desc",
                "status" => 5,
                "seed_key" => 1,
                "created_at" => date("Y-m-d H:i:s"),
            ],
            [
                "id_organization" => 0,
                "title" => "Financial",
                "description" => "financial Desc",
                "status" => 5,
                "seed_key" => 2,
                "created_at" => date("Y-m-d H:i:s"),
            ],
            [
                "id_organization" => 0,
                "title" => "Operational",
                "description" => "Operational Desc",
                "status" => 5,
                "seed_key" => 3,
                "created_at" => date("Y-m-d H:i:s"),
            ],
            [
                "id_organization" => 0,
                "title" => "Compliance",
                "description" => "Compliance Desc",
                "status" => 5,
                "seed_key" => 4,
                "created_at" => date("Y-m-d H:i:s"),
            ],
        ];

        if (sizeof($cekDb) == 0) {
            DB::table($table)->insert($dataSeed);
        } else {
            foreach ($dataSeed as $key => $oc) {
                $getOc = json_decode(json_encode(DB::table($table)->where("seed_key", $oc["seed_key"])->first()), true);

                if (isset($getOc["seed_key"])) {
                    DB::table($table)->where("seed_key", $oc["seed_key"])->update($oc);
                } else {
                    DB::table($table)->insert($oc);
                }
            }
        }
    }
}
