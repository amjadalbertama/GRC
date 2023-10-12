<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
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

        if (sizeof($cekDb) == 0) {
            DB::table($table)
                ->insert([
                    'status' => 'Created',
                    'style' => 'text-secondary',
                    'text' => "Wating for BPO Manager's checking process.",
                ]);
            DB::table($table)
                ->insert([
                    'status' => 'Recheck',
                    'style' => 'text-warning',
                    'text' => "Wating for BPO Staff checking process.",
                ]);
            DB::table($table)
                ->insert([
                    'status' => 'Resubmitted',
                    'style' => 'text-secondary',
                    'text' => "Wating for BPO Manager's checking process.",
                ]);
            DB::table($table)
                ->insert([
                    'status' => 'Reviewed',
                    'style' => 'text-body',
                    'text' => "Wating for Top Management checking process.",
                ]);
            DB::table($table)
                ->insert([
                    'status' => 'Approved',
                    'style' => 'text-success',
                    'text' => "Proses Approved by Top Management",
                ]);
            DB::table($table)
                ->insert([
                    'status' => 'Delete request',
                    'style' => 'text-danger',
                    'text' => "Proses Deleted",
                ]);
            DB::table($table)
                ->insert([
                    'status' => 'Checked',
                    'style' => 'text-body',
                    'text' => "Wating for Reviewer checking process.",
                ]);
        }
    }
}
