<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'roles';
        $cekDb = DB::table($table)->get();
        $dataVal = [
            ['role' => 'admin'],
            ['role' => 'staff'],
            ['role' => 'manager'],
            ['role' => 'reviewer'],
            ['role' => 'top_management'],
            ['role' => 'control'],
            ['role' => 'supervisor'],
            ['role' => 'corporate_secretary']
        ];


        if (sizeof($cekDb) == 0) {

            DB::table($table)->insert($dataVal);
        } else {
            foreach ($dataVal as $key => $rl) {
                $getRoles = json_decode(json_encode(DB::table($table)->where("role", $rl["role"])->first()), true);

                if (!isset($getRoles["role"])) {
                    DB::table($table)->insert($rl);
                }
            }
        }
    }
}
