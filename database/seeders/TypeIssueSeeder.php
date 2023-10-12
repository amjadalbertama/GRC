<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'type_issue';
        $cekDb = DB::table($table)->get();

        $dataTypeIssue = [
            [
                'name_type_issue' => 'Control-generated',
                'seed_key' => 0,
            ],
            [
                'name_type_issue' => 'Non-confirmity',
                'seed_key' => 1,
            ],
            [
                'name_type_issue' => 'Compliance',
                'seed_key' => 2,
            ],
        ];

        if (sizeof($cekDb) == 0) {
            DB::table($table)->insert($dataTypeIssue);
        } else {
            foreach ($dataTypeIssue as $key => $is) {
                $getTypeIssue = json_decode(json_encode(DB::table($table)->where("seed_key", $is["seed_key"])->first()), true);

                if (isset($getTypeIssue["name_type_issue"])) {
                    DB::table($table)->where("seed_key", $is["seed_key"])->update($is);
                } else {
                    DB::table($table)->insert($is);
                }
            }
        }
    }
}
