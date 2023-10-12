<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeStatfollowupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'type_statfollowup_issue';
        $cekDb = DB::table($table)->get();

        $dataCek = [
            [
                'name_status' => 'Open',
                'style_status' => 'text-body',
                'position' => 0,
            ],
            [
                'name_status' => 'Resolved',
                'style_status' => 'text-success',
                'position' => 1,
            ],
            [
                'name_status' => 'Expired',
                'style_status' => 'text-danger',
                'position' => 2,
            ]
        ];


        if (sizeof($cekDb) == 0) {
            DB::table($table)->insert($dataCek);
        } else {
            foreach ($dataCek as $key => $is) {
                $getSatus = json_decode(json_encode(DB::table($table)->where("position", $is["position"])->first()), true);

                if (isset($getSatus["name_status"])) {
                    DB::table($table)->where("position", $is["position"])->update($is);
                } else {
                    DB::table($table)->insert($is);
                }
            }
        }
    }
}
