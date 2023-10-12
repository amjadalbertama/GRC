<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeCategoryIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'issue_category';
        // $cekDb = DB::table($table)->get();
        $cekDb = DB::table($table)->get();

        $dataType = [
            [
                "name_category_issue" => "People",
                "position" => 0,
            ],
            [
                "name_category_issue" => "Process",
                "position" => 1,
            ],
            [
                "name_category_issue" => "Tools",
                "position" => 2,
            ],
            [
                "name_category_issue" => "Resource",
                "position" => 3,
            ],
        ];

        if (sizeof($cekDb) == 0) {
            // echo "masuk sini gan";
            DB::table($table)->insert($dataType);
        } else {
            foreach ($dataType as $key => $pg) {
                $getPages = json_decode(json_encode(DB::table($table)->where("position", $pg["position"])->first()), true);
                if (isset($getPages["name_category_issue"])) {
                    echo "Ngapdet";
                    DB::table($table)->where("position", $pg["position"])->update($pg);
                } else {
                    echo "Ngasup";
                    DB::table($table)->insert($pg);
                }
            }
        }
    }
}
