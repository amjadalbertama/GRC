<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplianceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'compliance_category';
        $cekDb = DB::table($table)->get();

        $dataInfoSource = [
            [
                'status' => 5,
                'name' => 'Legal Requirements',
                'description' => 'Perspiciatis unde omnis iste natus error sit volupt',
                'type' => 'Mandatory',
                'position' => 0,
            ],
            [
                'status' => 5,
                'name' => 'Ethics & Standards',
                'description' => 'Perspiciatis unde omnis iste natus error sit volupt',
                'type' => 'Voluntary',
                'position' => 1,
            ],
            [
                'status' => 5,
                'name' => 'Internal Guidelines',
                'description' => 'Perspiciatis unde omnis iste natus error sit volupt',
                'type' => 'Voluntary',
                'position' => 2,
            ],
            [
                'status' => 5,
                'name' => 'GCG Principles',
                'description' => 'Perspiciatis unde omnis iste natus error sit volupt',
                'type' => 'Voluntary',
                'position' => 3,
            ],

        ];

        if (sizeof($cekDb) == 0) {
            // echo "masuk sini gan";
            DB::table($table)->insert($dataInfoSource);
        } else {
            foreach ($dataInfoSource as $info) {
                $getInfo = json_decode(json_encode(DB::table($table)->where("position", $info["position"])->first()), true);

                if (isset($getInfo["name"])) {
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
