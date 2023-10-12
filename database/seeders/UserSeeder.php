<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{
    DB,
    Hash
};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cekUser = DB::table('users')->where('email', '=', 'admingrc@gmail.com')->first();
        if (!isset($cekUser->email)) {
            DB::table('users')->insert([
                'name' => 'Super Admin',
                'email' => 'admingrc@gmail.com',
                'password' => Hash::make('loginPass'),
                'org_id' => 1,
                'role_id' => 1
            ]);
        }
    }
}
