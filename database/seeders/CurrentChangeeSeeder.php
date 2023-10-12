<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrentChangeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'current_change';
        $cekDb = DB::table($table)->get();

        if (sizeof($cekDb) == 0) {
            DB::table($table)
                ->insert([
                    'id' => 1,
                    'current_change' => 'Excellent',
                ]);
            DB::table($table)
                ->insert([
                    'id' => 2,
                    'current_change' => 'Need Improvement',
                ]);
            DB::table($table)
                ->insert([
                    'id' => 3,
                    'current_change' => 'Still Poor',
                ]);
        }
    }
}
