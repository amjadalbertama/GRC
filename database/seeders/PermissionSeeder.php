<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Junges\ACL\Models\Permission;
use Illuminate\Support\Facades\{
    DB,
    Hash
};

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $changeAutoInc = DB::statement("ALTER TABLE permissions AUTO_INCREMENT = 1;");
        if ($changeAutoInc == 1) {
            $permissions = [
                'organization',
                'capabilities',
                'biz_environment',
                'periods',
                'objective',
                'objective_category',
                'policies',
                'kpi',
                'strategies',
                'programs',
                'review_n_improvement',
                'ksf',
                'risk_appetite',
                'possibilityimpact',
                'impactcriteria',
                'likelihoodcriteria',
                'risk_matrix',
                'kri',
                'risk_register',
                'legal_requirement',
                'internal_guideline',
                'ethics_standard',
                'gcg_principles',
                'compliance_register',
                'compliance_category',
                'compliance_obligations',
                'controls',
                'kci',
                'audit',
                'issues',
                'maintanance',
                'report',
                'pengaturanumum',
                'masterdata',
                'user',
                'hak_akses',
            ];

            foreach ($permissions as $permission) {
                $cekAddPermission = Permission::where("name", 'add ' . $permission)->first();
                if (!isset($cekAddPermission)) {
                    Permission::create(['name' => 'add ' . $permission]);
                }
                $cekViewPermission = Permission::where("name", 'view ' . $permission)->first();
                if (!isset($cekViewPermission)) {
                    Permission::create(['name' => 'view ' . $permission]);
                }
                $cekUpdPermission = Permission::where("name", 'update ' . $permission)->first();
                if (!isset($cekUpdPermission)) {
                    Permission::create(['name' => 'update ' . $permission]);
                }
                $cekDelPermission = Permission::where("name", 'delete ' . $permission)->first();
                if (!isset($cekDelPermission)) {
                    Permission::create(['name' => 'delete ' . $permission]);
                }
                $cekAppPermission = Permission::where("name", 'approval ' . $permission)->first();
                if (!isset($cekAppPermission)) {
                    Permission::create(['name' => 'approval ' . $permission]);
                }
                $cekRevPermission = Permission::where("name", 'reviewer ' . $permission)->first();
                if (!isset($cekRevPermission)) {
                    Permission::create(['name' => 'reviewer ' . $permission]);
                }
            }
        }
    }
}
