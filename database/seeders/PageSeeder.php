<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $table = 'pages';
        $cekDb = DB::table($table)->get();

        $dataVal = [
            [
                'page' => 'Organization',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'organization',
                'position' => 1,
                'position_group' => 1,
            ],
            [
                'page' => 'Capabilities',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'capabilities',
                'position' => 2,
                'position_group' => 1,
            ],
            [
                'page' => 'Periods',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'periods',
                'position' => 3,
                'position_group' => 1,
            ],
            [
                'page' => 'Biz Environment',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'biz_environment',
                'position' => 4,
                'position_group' => 1,
            ],
            [
                'page' => 'Policies',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'policies',
                'position' => 5,
                'position_group' => 1,
            ],
            [
                'page' => 'KPI',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'kpi',
                'position' => 6,
                'position_group' => 1,
            ],
            [
                'page' => 'Objective Category',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'objective_category',
                'position' => 7,
                'position_group' => 1,
            ],
            [
                'page' => 'Objectives',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'objective',
                'position' => 8,
                'position_group' => 1,
            ],
            [
                'page' => 'Strategies',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'strategies',
                'position' => 9,
                'position_group' => 1,
            ],
            [
                'page' => 'Programs',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'programs',
                'position' => 10,
                'position_group' => 1,
            ],
            [
                'page' => 'Review and Improvement',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'review_n_improvement',
                'position' => 11,
                'position_group' => 1,
            ],
            [
                'page' => 'KSF',
                'deskripsi' => '',
                'page_group' => 'Governence',
                'permission' => 'ksf',
                'position' => 12,
                'position_group' => 1,
            ],
            [
                'page' => 'Risk Appetite',
                'deskripsi' => '',
                'page_group' => 'Risk',
                'permission' => 'risk_appetite',
                'position' => 1,
                'position_group' => 2,
            ],
            [
                'page' => 'Impact Criteria',
                'deskripsi' => '',
                'page_group' => 'Risk',
                'permission' => 'impactcriteria',
                'position' => 3,
                'position_group' => 2,
            ],
            [
                'page' => 'Likelihood Criteria',
                'deskripsi' => '',
                'page_group' => 'Risk',
                'permission' => 'likelihoodcriteria',
                'position' => 4,
                'position_group' => 2,
            ],
            [
                'page' => 'Risk Matrix',
                'deskripsi' => '',
                'page_group' => 'Risk',
                'permission' => 'risk_matrix',
                'position' => 5,
                'position_group' => 2,
            ],
            [
                'page' => 'KRI',
                'deskripsi' => '',
                'page_group' => 'Risk',
                'permission' => 'kri',
                'position' => 6,
                'position_group' => 2,
            ],
            [
                'page' => 'Risk Register',
                'deskripsi' => '',
                'page_group' => 'Risk',
                'permission' => 'risk_register',
                'position' => 7,
                'position_group' => 2,
            ],
            [
                'page' => 'Legal Requirements',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'legal_requirement',
                'position' => 1,
                'position_group' => 3,
            ],
            [
                'page' => 'Internal Guideline',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'internal_guideline',
                'position' => 2,
                'position_group' => 3,
            ],
            [
                'page' => 'Ethics Standard',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'ethics_standard',
                'position' => 3,
                'position_group' => 3,
            ],
            [
                'page' => 'GCG Principles (TARIFF)',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'gcg_principles',
                'position' => 4,
                'position_group' => 3,
            ],
            [
                'page' => 'Compliance Register',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'compliance_register',
                'position' => 5,
                'position_group' => 3,
            ],
            [
                'page' => 'Compliance Category',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'compliance_category',
                'position' => 6,
                'position_group' => 3,
            ],
            [
                'page' => 'Compliance Obligations',
                'deskripsi' => '',
                'page_group' => 'Compliance',
                'permission' => 'compliance_obligations',
                'position' => 7,
                'position_group' => 3,
            ],
            [
                'page' => 'Control',
                'deskripsi' => '',
                'page_group' => 'Control',
                'permission' => 'controls',
                'position' => 1,
                'position_group' => 4,
            ],
            [
                'page' => 'Audit',
                'deskripsi' => '',
                'page_group' => 'Control',
                'permission' => 'audit',
                'position' => 2,
                'position_group' => 4,
            ],
            [
                'page' => 'Issues',
                'deskripsi' => '',
                'page_group' => 'Control',
                'permission' => 'issues',
                'position' => 3,
                'position_group' => 4,
            ],
            [
                'page' => 'Maintenance',
                'deskripsi' => '',
                'page_group' => 'Control',
                'permission' => 'maintanance',
                'position' => 4,
                'position_group' => 4,
            ],
            [
                'page' => 'Report',
                'deskripsi' => '',
                'page_group' => 'Control',
                'permission' => 'report',
                'position' => 5,
                'position_group' => 4,
            ],
            [
                'page' => 'KCI',
                'deskripsi' => '',
                'page_group' => 'Control',
                'permission' => 'kci',
                'position' => 6,
                'position_group' => 4,
            ],
            [
                'page' => 'Pengaturan Umum',
                'deskripsi' => '',
                'page_group' => 'Settings',
                'permission' => 'pengaturanumum',
                'position' => 1,
                'position_group' => 5,
            ],
            [
                'page' => 'Master Data',
                'deskripsi' => '',
                'page_group' => 'Settings',
                'permission' => 'masterdata',
                'position' => 2,
                'position_group' => 5,
            ],
            [
                'page' => 'User',
                'deskripsi' => '',
                'page_group' => 'Settings',
                'permission' => 'user',
                'position' => 3,
                'position_group' => 5,
            ],
            [
                'page' => 'Hak Akses',
                'deskripsi' => '',
                'page_group' => 'Settings',
                'permission' => 'hak_akses',
                'position' => 4,
                'position_group' => 5,
            ],
        ];

        if (sizeof($cekDb) == 0) {
            // echo "masuk sini gan";
            DB::table($table)->insert($dataVal);
        } else {
            foreach ($dataVal as $key => $pg) {
                $getPages = json_decode(json_encode(DB::table($table)->where("position", $pg["position"])->first()), true);

                if (isset($getPages["position"])) {
                    DB::table($table)->where("position", $pg["position"])->where("position_group", $pg["position_group"])->update($pg);
                } else {
                    DB::table($table)->insert($pg);
                }
            }
        }
    }
}
