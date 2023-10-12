<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusMappingAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'status_mapping';
        $cekDb = DB::table($table)->get();

        $updateMap = [
            [
                "id" => 1,
                "alert_style" => "alert-secondary",
            ],
            [
                "id" => 2,
                "alert_style" => "alert-warning",
            ],
            [
                "id" => 3,
                "alert_style" => "alert-secondary",
            ],
            [
                "id" => 4,
                "alert_style" => "alert-body",
            ],
            [
                "id" => 5,
                "alert_style" => "alert-success",
            ],
            [
                "id" => 6,
                "alert_style" => "alert-danger",
            ],
            [
                "id" => 7,
                "alert_style" => "alert-body",
            ],
        ];

        foreach ($updateMap as $key => $map) {
            $updMap = DB::table($table)->where("id", $map["id"])->update($map);
        }
    }
}
