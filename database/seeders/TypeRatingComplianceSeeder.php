<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeRatingComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'type_rating_compliance';
        $cekDb = DB::table($table)->get();

        $dataTypeRating = [
            [
                'name_rating' => 'Low',
                'style_rating' => 'text-success',
                'seed_key' => 0,
            ],
            [
                'name_rating' => 'Medium',
                'style_rating' => 'text-yellow',
                'seed_key' => 1,
            ],
            [
                'name_rating' => 'High',
                'style_rating' => 'text-warning',
                'seed_key' => 2,
            ],
            [
                'name_rating' => 'Significant',
                'style_rating' => 'text-danger',
                'seed_key' => 3,
            ],
        ];

        if (sizeof($cekDb) == 0) {
            DB::table($table)->insert($dataTypeRating);
        } else {
            foreach ($dataTypeRating as $key => $is) {
                $getTypeIssue = json_decode(json_encode(DB::table($table)->where("seed_key", $is["seed_key"])->first()), true);

                if (isset($getTypeIssue["name_rating"])) {
                    DB::table($table)->where("seed_key", $is["seed_key"])->update($is);
                } else {
                    DB::table($table)->insert($is);
                }
            }
        }
    }
}
