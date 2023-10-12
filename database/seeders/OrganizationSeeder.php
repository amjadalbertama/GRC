<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'organization';
        $cekDb = DB::table($table)->get();

        if (sizeof($cekDb) == 0) {
            DB::table($table)
                ->insert([
                    'name_org' => 'Default Organization',
                    'upper_org_id' => 0,
                    'lead_role' => 7,
                    'description' => 'Default Organization',
                    'notes' => '',
                    'status' => 5,
                ]);
        }
    }
}
