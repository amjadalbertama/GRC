<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Junges\ACL\Models\Group;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $changeAutoInc = DB::statement("ALTER TABLE `groups` AUTO_INCREMENT = 1;");
        $groupCek = Group::where("name", "=", "Super Admin")->first();
        if (!isset($groupCek->name)) {
            $group = Group::create(['name' => 'Super Admin']);
            $user = User::where('email', 'admingrc@gmail.com')->update([
                "group_id" => $group->id,
                "org_id" => 0,
                "role_id" => 1,
            ]);
        }
    }
}
