<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $listClass = [];
        // if ($handle = opendir('database\seeders')) {
        //     while (false !== ($entry = readdir($handle))) {
        //         if ($entry != "." && $entry != "..") {
        //             if ($entry != "DatabaseSeeder.php") {
        //                 $separate = explode(".php", $entry);
        //                 array_push($listClass, $separate[0]."::class");
        //             }
        //         }
        //     }
        //     closedir($handle);
        // }

        // print_r($listClass);
        // $this->call($listClass);
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            PageSeeder::class,
            PermissionSeeder::class,
            StatusSeeder::class,
            SuperAdminSeeder::class,
            RolesSeeder::class,
            RiskRegisterEvaluationAcceptRejectSeeder::class,
            RiskRegisterTreatmentType::class,
            RolesSeeder::class,
            StatusMappingAlertSeeder::class,
            RiskRegisterStatusMapping::class,
            TypeGovernanceSeeder::class,
            TypeRatingComplianceSeeder::class,
            TypeStatfollowupSeeder::class,
            IssueInformationSourceSeeder::class,
            CurrentChangeeSeeder::class,
            TypeCategoryIssueSeeder::class,
            TypeIssueSeeder::class,
            ComplianceCategorySeeder::class,
            ComplianceStatusFulfilledSeeder::class,
            OrganizationSeeder::class,
            ObjectiveCategorySeeder::class,
        ]);
    }
}
