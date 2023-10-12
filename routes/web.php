<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    LoginController,
    SettingsController,
    HakAksesController,
    ObjectegoryController,
    ObjectiveController,
    KsfController,
    BizenvirnmtController,
    DammyriskController,
    UserController,
    GroupPermissionsController,
    RiskAppetiteController,
};

use App\Http\Controllers\Governances\{
    PeriodsController,
    CapabilitiesController,
    OrganizationController,
    PoliciesController,
    StrategiesController,
    KpiController,
    ProgramsController,
    EvaluasiController,
    ReviewImprovementController
};
use App\Http\Controllers\Risks\{
    LikelihoodCriteriaController,
    ImpactCriteriaController,
    RegisterController,
    RiskMatrixController,
    KriController
};

use App\Http\Controllers\Compliance\{
    ComplianceCategoryController,
    ComplianceObligationsController,
    ComplianceRegisterController
};

use App\Http\Controllers\General\{
    HomeController,
    DashboardController,
};

use App\Http\Controllers\Control\{
    ControlsController,
    IssueController,
    MonevController,
    KciController,
    AuditController
};

use App\Http\Controllers\Report\{
    ReportAuditController,
    ReportComplianceController,
    ReportControlController,
    ReportGovernanceController,
    ReportIssueController,
    ReportMonevController,
    ReportOverviewController,
    ReportRiskController
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login')->name('login.submit');
    Route::get('/', 'index')->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(HomeController::class)->group(function ($app) {
        $app->get('home', 'index')->name('home');
        $app->get('profile', 'profile')->name('profile_home');
        $app->get('notification', 'notification')->name('notification');
    });

    Route::controller(UserController::class)->group(function () {
        Route::post('/adduser', 'store')->name('adduser');
        Route::post('/edituser/{id}', 'update')->name('edituser');
        Route::get('/users', 'index')->name('users');
        Route::post('/users', 'index')->name('users_search');
        Route::get('/users/{id}', 'delete')->name('deluser');
    });

    Route::controller(HakAksesController::class)->group(function () {
        Route::get('/hakakses', 'index')->name('access');
        Route::get('/hakakses/edit/{id}', 'detail')->name('editaccess');
        Route::post('/hakakses/update/{id}', 'updateAcc')->name('updateaccess');
        Route::get('/hakakses/delete/{id}', 'destroy')->name('deleteaccess');
    });

    Route::controller(DashboardController::class)->group(function ($app) {
        $app->get('dashboard', 'index_dashboard')->name('dashboard_index');
        $app->get('governance', 'index_governance')->name('governance_index');
        $app->get('achievements', 'index_achievement')->name('achievements_index');
        $app->get('key_indicators', 'index_key_indicator')->name('key_indicators_index');
        $app->get('obligations', 'index_obligation')->name('obligations_index');
        $app->get('risks', 'index_risks')->name('risks_index');
        $app->post('api/v1/objective/get', 'getObjective')->name('getobjective');
        $app->post('api/v1/obligations/get', 'getObligations')->name('getobligations');
        $app->post('api/v1/achievement/get', 'getAchievement')->name('getachievement');
        $app->post('api/v1/objective/achievements/get', 'getObjectiveAchievement')->name('getobjectiveachievement');
        $app->post('api/v1/dashboard/risks/get', 'getRisks')->name('getobjectiveachievement');

        $app->post('api/v1/key_indicators/kpi', 'getListKpi')->name('get_key_indicator_kpi');
        $app->post('api/v1/key_indicators/kci', 'getListKci')->name('get_key_indicator_kci');
        $app->post('api/v1/key_indicators/kri', 'getListKri')->name('get_key_indicator_kri');
    });

    Route::controller(SettingsController::class)->group(function () {
        Route::get('settings', 'index')->name('settings');
    });

    Route::resource('hakakses', HakAksesController::class);
    Route::resource('user', UserController::class);

    # LOGOUT
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    //Organization---->
    Route::controller(OrganizationController::class)->group(function () {
        Route::post('/addorg', 'add')->name('addorg');
        Route::get('/organization', 'getView')->name('organization');
        Route::post('/organization', 'getView')->name('organization_search');
        Route::patch('/editorg/{id}', 'update')->name('editorg');
        Route::get('/delorg/{id}', 'delete')->name('orgdel');
        Route::patch('/approveorg/{id}', 'approval')->name('approveorg');
        // Export Data
        Route::get('/export_organization', 'exportData')->name('export_organization');

        // API route
        Route::get('/api/v1/organization/get', 'getListOrg')->name('getorganization');
    });

    //Capabilities---->
    Route::controller(CapabilitiesController::class)->group(function () {
        Route::post('/addcapabilities', 'add')->name('addcapabilities');
        Route::get('/capabilities', 'getView')->name('capabilities');
        Route::post('/capabilities', 'getView')->name('capabilities_search');
        Route::patch('/editcapabilities/{id}', 'update')->name('edtcapabilities');
        Route::get('/delcapabilities/{id}', 'delete')->name('delcapabilities');
        Route::patch('/approvecap/{id}', 'approval')->name('approvecap');
        
        // Export Data
        Route::get('/export_capabilities', 'exportData')->name('export_capabilities');
    });

    //Biz Environment
    Route::controller(BizenvirnmtController::class)->group(function () {
        Route::get('/bizenvirnmt', 'getView')->name('bzenvir');
        Route::post('/bizenvirnmt', 'getView')->name('bzenvir');
        Route::post('/addenvironment', 'add')->name('addenvironment');
        Route::patch('/editenvironment/{id}', 'update')->name('edtenvironment');
        Route::get('/delenvironment/{id}', 'delete')->name('delenvironment');
        Route::patch('/approveenvironment/{id}', 'approval')->name('approveenvironment');
        Route::get('get-organization', 'getOrganization')->name('organization');
        Route::post('/bizenvirnmt/get-period-by-bizenvirnmt', 'getPeriod');
        Route::get('/export_biz', 'exportData')->name('export_bzenvir');
    });

    //Periods---->
    Route::controller(PeriodsController::class)->group(function () {
        Route::get('/periods', 'getView')->name('periods');
        Route::post('/periods', 'getView')->name('periods_search');
        Route::post('/addperiods', 'add')->name('addperiods');
        Route::patch('/editperiods/{id}', 'update')->name('edtperiods');
        Route::get('/delperiods/{id}', 'delete')->name('delperiods');
        Route::patch('/approveperiods/{id}', 'approval')->name('approveperiods');

        // Export Data
        Route::get('/export_periods', 'exportData')->name('export_periods');
    });

    //Risk Management..........................................................................>

    //Impact Criteria---->

    Route::controller(ImpactCriteriaController::class)->group(function () {
        Route::get('/impactria', 'getImpactCriteria')->name('impactria');
        Route::post('/impactria', 'getImpactCriteria')->name('impactria');
        Route::get('/impactdetail/{id}', 'getImpactCriteriaDetail')->name('impactdetail');
        Route::post('/addimpactcriteria', 'addImpactCriteriaDetail')->name('addimpactcriteria');
        Route::post('/editimpactcriteria', 'editImpactCriteriaDetail')->name('editimpactcriteria');
        Route::post('/delimpactarea', 'delImpactAreaDetail')->name('delimpactarea');
        Route::post('/approveimpactcriteria/{id}', 'approveImpactCriteria')->name('approveimpactcriteria');
        Route::post('api/v1/impact_criteria/generate', 'generateIC')->name('generate_impact_criteria');
        Route::post('/delete_impact/{id}', 'delImpact')->name('delimpact');

        //Export Data
        Route::get('/export_impact', 'exportData')->name('export_impact');
    });

    //Likelihood----->
    Route::controller(LikelihoodCriteriaController::class)->group(function () {
        Route::get('/likelihood', 'getView')->name('likelihood');
        Route::post('/likelihood', 'getView')->name('likelihood');
        Route::post('/likelihood/search', 'getView')->name('likelihood_search');
        Route::post('/addlikelihood', 'add')->name('addlikelihood');
        Route::patch('/editlikelihood/{id}', 'update')->name('edtlikelihood');
        Route::get('/dellikelihood/{id}', 'delete')->name('dellikelihood');
        Route::get('/detlikelihood/{id}', 'details')->name('detlikelihood');
        Route::patch('/approvelikelihood/{id}', 'approval')->name('approveLikelihood');
        Route::post('api/v1/likelihood/generate', 'generateLikelihood')->name('generate_likelihood');
        Route::post('detlikelihood/{id}/likelihood/approval', 'resubmitted')->name('approval_likelihood');
        Route::get('/export_likelihood', 'exportData')->name('export_likelihood');
        Route::get('/export_detlikelihood/{id}', 'exportDataDetails')->name('export_detlikelihood');
    });

    //Compliance...............................................................................>
    //Compliance Category----->
    Route::controller(ComplianceCategoryController::class)->group(function ($app) {
        $app->get('/complianceCategory',  'getView')->name('complianceCategory');
        $app->post('/complianceCategory',  'getView')->name('complianceCategory');
        $app->post('/complianceCategory/search',  'getView')->name('complianceCate_search');
        $app->post('/addcomplianceCategory', 'add')->name('addcomplianceCategory');
        $app->patch('/editcomplianceCategory/{id}', 'update')->name('edtcomplianceCategory');
        $app->get('/delcomplianceCategory/{id}', 'delete')->name('delcomplianceCategory');
        $app->patch('/approvecomcat/{id}', 'approval')->name('approveComcat');
        $app->get('/export_comcat', 'exportData')->name('export_comcat');
    });

    //Compliance Obligations----->
    Route::controller(ComplianceObligationsController::class)->group(function ($app) {
        $app->get('/complianceObligations',  'getView')->name('complianceObligations');
        $app->post('/complianceObligations',  'getView')->name('complianceObligations');
        $app->post('/complianceObligations/search',  'getView')->name('complianceObligat_search');
        $app->get('api/v1/add/compob', 'addViewCompOb')->name('addCompOb');
        $app->get('api/v1/detail/compob/{id}', 'detailsCompOb')->name('detailsCompob');
        $app->get('api/v1/edit/compob/{id}', 'editViewCompOb')->name('editCompobShow');
        $app->get('/complianceObligations/delete/compob/{id}', 'deleteConfirmCompOb')->name('deleteConfirm');
        $app->post('api/v1/add/selectorg', 'showLead')->name('showLead');
        $app->post('api/v1/add/save', 'saveComOb')->name('addCompOb');
        $app->post('api/v1/edit/save/{id}', 'update')->name('updateCompob');
        $app->post('api/v1/delete/{id}', 'delete')->name('deleteCompob');
        $app->get('/export_comobg', 'exportData')->name('export_comobg');
    });

    //Compliance Register----->
    Route::controller(ComplianceRegisterController::class)->group(function ($app) {
        $app->get('/complianceRegister',  'getView')->name('complianceRegister');
        $app->post('/complianceRegister',  'getView')->name('complianceRegister');
        $app->post('/complianceRegister/search',  'getView')->name('complianceRegister_search');
        $app->get('api/v1/detail/compreg/{id}', 'detailsComplianceReg')->name('detailsCompreg');
        $app->post('api/v1/save/compreg/{id}', 'saveCompreg')->name('saveCompreg');
        $app->post('/addcomplianceRegister', 'add')->name('addcomplianceRegister');
        $app->patch('/editcomplianceRegister/{id}', 'update')->name('edtcomplianceRegister');
        $app->get('/delcomplianceRegister/{id}', 'delete')->name('delcomplianceRegister');
        $app->post('api/v1/complianceRegister/generate/{id}', 'generateCompliance')->name('generate_compliance');
        $app->get('/export_comreg', 'exportData')->name('export_comreg');
    });

    //Objective Category---->
    Route::controller(ObjectegoryController::class)->group(function () {
        Route::get('/objectegory', 'getView')->name('objectegory');
        Route::post('/objectegory', 'getView')->name('objectegory');
        Route::post('/addobjectegory', 'add')->name('addobjectegory');
        Route::patch('/editobjectegory/{id}', 'update')->name('edtobjectegory');
        Route::get('/delobjectegory/{id}', 'delete')->name('delobjectegory');
        Route::patch('/appobjectegory/{id}', 'approval')->name('appobjectegory');
    });

    //Objective---->
    Route::controller(ObjectiveController::class)->group(function ($app) {
        $app->get('/objective', 'getView')->name('objective');
        $app->post('/objective', 'getView')->name('objective');
        $app->post('/addobjective', 'add')->name('addobjective');
        $app->patch('/editobjective/{id}', 'update')->name('editobjective');
        $app->delete('/delobjective/{id}', 'delete')->name('delobjective');
        $app->patch('/appobjective/{id}', 'approval')->name('appobjective');
        $app->post('api/v1/objective/generate/riskidentification', 'addriskident')->name('addriskidentification');
        $app->post('api/v1/objective/generate/kpi', 'addkpi')->name('addKPI');
        $app->post('api/v1/get_biz_by_period', 'getBiz')->name('getbizenvirontment');
        $app->get('api/v1/get_kpi_by_id/{id}', 'getkpi')->name('getKpi');
        $app->get('api/v1/get_kpi_objective/{id}', 'getKpiObj')->name('getkpiobj');
        $app->delete('api/v1/del_kpi_objective/{id}', 'delKpiObj')->name('delkpiobj');
        $app->delete('api/v1/del_risk_identification/{id}', 'delRiskIdentification')->name('delriskidentification');
    });

    Route::controller(RiskAppetiteController::class)->group(function () {
        Route::get('/risk_appetite', 'getView')->name('risk_appetite');
        Route::post('/risk_appetite', 'getView')->name('risk_appetite');
        Route::get('/risk_appetite_category/{id}', 'getViewCategory')->name('risk_appetite_category');
        Route::patch('/editrisk_appetite_category/{id}', 'update')->name('editrisk_appetite_category');
        Route::patch('/appriskappetite/{id}', 'approval')->name('appriskappetite');
        Route::post('api/v1/risk_appetite/generate', 'generateRA')->name('generate_risk_appetites');
    });

    Route::controller(RiskMatrixController::class)->group(function () {
        Route::get('/risk_matrix', 'getView')->name('risk_matrix');
        Route::post('/risk_matrix', 'getView')->name('risk_matrix');
        Route::get('/risk_matrix_settings/{id}', 'getViewSetting')->name('risk_matrix_settings');
        Route::post('/saverisk_matrix_line_threshold/{id}', 'saveRiskMatrixThresholdLine')->name('saverisk_matrix_line_threshold');
        Route::post('/saverisk_matrix_line_tolerance/{id}', 'saveRiskMatrixToleranceLine')->name('saverisk_matrix_line_tolerance');
        Route::post('/saverisk_matrix/{id}', 'saveRiskMatrix')->name('saverisk_matrix');
        Route::patch('/risk_matrix/approve/{id}', 'approveRiskMatrix')->name('approveRiskMatrix');
        // Route::post('/objective/risk_appetite/generate', 'generateRA')->name('generate_risk_appetites');

        //Export Data
        Route::get('/export_matrix', 'exportData')->name('export_matrix');
    });

    Route::post('/objective/risk_appetite/generate', [RiskAppetiteController::class, 'generateRA'])->name('generate_risk_appetite');

    // Route::post('/objective/risk_appetite/generate', [RiskAppetiteController::class, 'generateRA'])->name('generate_risk_appetite');

    //KPI---->
    Route::controller(KpiController::class)->group(function ($app) {
        $app->get('/kpi',  'getView')->name('kpi');
        $app->post('/kpi',  'getView')->name('kpi');
        $app->post('/kpi/search', 'getView')->name('kpi_search');
        $app->post('api/v1/kpi/generate', 'generateKpi')->name('generate_kpi');
        $app->post('api/v1/kpi/editPeriod', 'editPeriodKpi')->name('edit_period');
        $app->post('api/v1/kpi/editPeriodEnd', 'editPeriodKpiEnd')->name('edit_period_end');
        $app->patch('/editStatuskpi/{id}',  'updateMonitoringStatus')->name('edtStatuskpi');
        $app->get('api/v1/detailskpi/{id}', 'detailsKpi')->name('detailsKpi');
        $app->post('api/v1/save/statuskpi/{id}', 'saveStatKpi')->name('savestatuskpi');
        $app->get('api/v1/delete/modalreason/kpi/{id}', 'confirmKpi')->name('confirmKpi');
        $app->post('api/v1/delete/kpi/{id}', 'deleteKpi')->name('confirmKpi');
        $app->post('api/v1/generate/issue/kpi/{id}', 'generateKpiIssue')->name('generateKpiIssue');
        $app->get('/export_kpi', 'exportData')->name('export_kpi');
    });

    //KSF---->
    Route::get('/ksf', [KsfController::class, 'getView'])->name('ksf');
    Route::post('/addksf', [KsfController::class, 'add'])->name('addksf');
    Route::patch('/editksf/{id}', [KsfController::class, 'update'])->name('edtksf');
    Route::get('/delksf/{id}', [KsfController::class, 'delete'])->name('delksf');

    //Review n Improvement---->
    Route::controller(ReviewImprovementController::class)->group(function ($app) {
        $app->get('/reviewimprove', 'getView')->name('reviewimprove');
        $app->post('/reviewimprove', 'getView')->name('reviewimprove');
        $app->get('api/v1/edit/review/{id}', 'viewEdit')->name('editViewReview');
        $app->get('api/v1/view/notes/edit/{id}', 'viewEditNotes')->name('viewEditNotes');
        $app->get('api/v1/modal/add/monev/{id}', 'modalAddMonev')->name('modalMonev');
        $app->get('api/v1/modal/add/audit/{id}', 'modalAddAudit')->name('modalAudit');
        $app->get('api/v1/modal/add/program/{id}', 'modalAddProgram')->name('modalProgram');
        $app->get('/details/reviewimprove/{id}', 'details')->name('details_reviewImprove');
        $app->post('/details/reviewimprove/{id}', 'details')->name('details_reviewImprove');
        $app->post('api/v1/save/newreview', 'add')->name('addreviewImprove');
        $app->post('api/v1/save/edt/review/{id}', 'update')->name('edtreviewImprove');
        $app->get('api/v1/delete/review/{id}', 'delete')->name('delreviewImprove');
        $app->get('api/v1/delete/details/{id}', 'deleteDetails')->name('delReviewDetails');
        $app->get('api/v1/delete/notes/{id}', 'deleteNotes')->name('delNotesReview');
        $app->get('/export_reviewimprove', 'exportData')->name('export_reviewImprove');
        $app->get('/export_reviewimprove/details/{id}', 'exportDataDetails')->name('export_reviewDetails');
        $app->post('api/v1/add/monev/details', 'addMonev')->name('addMonevDetailReview');
        $app->post('api/v1/add/audit/details', 'addAudit')->name('addAuditDetailReview');
        $app->post('api/v1/add/program/details', 'addProgram')->name('addProgramDetailReview');
        $app->post('api/v1/save/notes/details', 'addNotes')->name('addNotesDetailReview');
    });
    //Policie---->
    Route::controller(PoliciesController::class)->group(function ($app) {
        $app->get('/policies', 'getView')->name('policies');
        $app->post('/policies', 'getView')->name('policies');
        $app->post('/addpolicies', 'addData')->name('addpolicies');
        $app->post('/editpolicies/{id}', 'update')->name('edtpolicies');
        $app->get('/delpolicies/{id}', 'delete')->name('delpolicies');
        $app->post('api/v1/policies/generate', 'generatePolicy')->name('generate_policies');
        $app->patch('/approvepolicies/{id}', 'approval')->name('approvepolicies');
        $app->post('api/v1/policies/generate/kpi', 'addKpi')->name('add_kpi');
        $app->delete('api/v1/del_kpi_policy/{id}', 'delKpiPol')->name('del_kpi_pol');
    });

    //Strategies
    Route::controller(StrategiesController::class)->group(function ($app) {
        $app->get('/strategies', 'getView')->name('strategies');
        $app->post('/strategies', 'getView')->name('strategies');
        $app->post('/addstrategies', 'add')->name('addstrategies');
        $app->post('/editstrategies/{id}', 'update')->name('edtstrategies');
        $app->delete('api/v1/strategies/delete/{id}', 'delete')->name('delstrategies');
        $app->post('api/v1/strategies/generate', 'generateStrategy')->name('generatestrategy');
        $app->get('api/v1/strategies/{id}', 'getStrategy')->name('apigetstrategy');
        $app->post('api/v1/strategies/approve/{id}', 'approvalStr')->name('approvestrategy');
    });

    //Programs
    Route::controller(ProgramsController::class)->group(function ($app) {
        $app->get('/programs', 'getView')->name('programs');
        $app->post('/programs', 'getView')->name('programs');
        $app->post('/addprograms', 'add')->name('addprograms');
        $app->patch('/editprograms/{id}', 'update')->name('edtprograms');
        $app->get('/delprograms/{id}', 'delete')->name('delprograms');
        $app->post('api/v1/programs/generate', 'generatePrograms')->name('generateprograms');
        $app->get('api/v1/programs/detail/{id}', 'detail')->name('detailprograms');
        $app->post('api/v1/programs/update/{id}', 'update')->name('updateprograms');
        $app->post('api/v1/programs/approve/{id}', 'approval')->name('approveprograms');
        $app->get('api/v1/programs/ksf/get/{id}', 'getKsf')->name('getksfprograms');
        $app->post('api/v1/programs/ksf/save', 'addKsf')->name('addksfprograms');
        $app->post('api/v1/programs/ksf/edit/{id}', 'editKsf')->name('editksfprograms');
        $app->post('api/v1/programs/ksf/delete/{id}', 'delKsf')->name('delksfprograms');
    });

    //Management Resiko/ Risk Management------------------------------------------------>
    //Head Map---->
    Route::get('/heatmap', [DammyriskController::class, 'getHeatmap'])->name('heatmap');

    //Likelihood Criteria---->

    //KRI---->
    Route::controller(KriController::class)->group(function ($app) {
        $app->get('/kri', 'getView')->name('kri');
        $app->post('/kri', 'getView')->name('kri');
        $app->get('api/v1/kri/{id}', 'getKri')->name('kriDet');
        $app->post('api/v1/editkri/{id}', 'editKri')->name('kriEdit');
        $app->post('api/v1/kri/generate', 'generateKri')->name('generatekri');
        $app->post('api/v1/delete/kri/{id}', 'deleteKri')->name('deletekri');
        $app->get('api/v1/generate/modal/kri/{id}', 'modalGenKri')->name('modalgenKri');
        $app->post('api/v1/generate/issue/kri/{id}', 'genIssueKri')->name('genIssueKri');
    });

    //Modul Management Control---------------------->
    //Issue
    Route::controller(IssueController::class)->group(function ($app) {
        $app->get('/issues', 'getView')->name('issues');
        $app->post('/issues', 'getView')->name('issues');
        $app->post('/issues/search', 'getView')->name('issue_search');
        $app->get('api/v1/add/issue', 'addViewIssue')->name('addIssue');
        $app->get('api/v1/detail/issue/{id}', 'detailsIssue')->name('detailsIssue');
        $app->post('api/v1/save/issue', 'saveIssue')->name('saveIssue');
        $app->get('api/v1/edit/issue/{id}', 'editViewIssue')->name('editIssueShow');
        $app->post('api/v1/save/edit/issue/{id}', 'editSaveIssue')->name('editIssueSave');
        $app->post('api/v1/delete/issue/{id}', 'delete')->name('deleteIssue');
        $app->post('api/v1//generate/issue/kci/{id}', 'generateKciIssue')->name('generateKciIssue');
        $app->get('/api/v1/issue/list_information_source', 'getInfoSource')->name('getInformationSource');
        $app->get('/export_issue', 'exportData')->name('export_issue');
    });

    //Monev
    Route::controller(MonevController::class)->group(function ($app) {
        $app->get('/monev', 'getView')->name('monev');
        $app->post('/monev/search', 'getView')->name('monev_search');
        $app->get('detail/monev/{id}', 'detailsMonev')->name('detailsMonev');
        $app->get('api/v1/achievement/monev/{id}', 'detailsAchievement')->name('detailsachievment');
        $app->get('detail/monev/indicators/monev/{id}', 'detailsIndicators')->name('indicatorsMonev');
        $app->get('detail/monev/strategy/{id}', 'detailsStrategies')->name('strategyMonev');
        $app->get('detail/monev/controls/monev/{id}', 'detailsControls')->name('controlsMonev');
        $app->get('detail/monev/controlsAct/monev/{id}', 'detailsMonControlsAct')->name('monevControlAct');
        $app->get('detail/monev/strategyprogram/monev/{id}/{id_obj}', 'detailsStrategyPrograms')->name('StrategyProgram');
        $app->get('api/v1/detail/monev/strpro/{id}', 'detailsStrgyPro')->name('detailsStrgyPro');
        $app->get('/export_monev', 'exportData')->name('export_monev');
    });

    //KCI
    Route::controller(KciController::class)->group(function ($app) {
        $app->get('/kci', 'getView')->name('kci');
        $app->post('/kci', 'getView')->name('kci');
        $app->post('/kci/search', 'getView')->name('kci_search');
        $app->get('api/v1/detailskci/{id}', 'detailsKci')->name('detailsKci');
        // $app->get('kci/detail/kci/{id}', 'detailskci')->name('detailskci');
        $app->post('api/v1/editkci/{id}', 'savestatus')->name('savestatus');
        $app->post('api/v1/delete/kci/{id}', 'deleteKci')->name('deletekci');
        $app->get('api/v1/kci/generate', 'generateKci')->name('generate_kci');
        $app->post('api/v1/generate/issue/kci/{id}', 'generateIssueKci')->name('genIssue_kci');
        $app->get('/export_kci', 'exportData')->name('export_kci');
    });

    //Control---->
    Route::controller(ControlsController::class)->group(function ($app) {
        $app->get('/controls', 'getView')->name('controls');
        $app->post('/controls', 'getView')->name('controls');
        $app->get('/controls/{id}', 'getControlAct')->name('controlActivity');
        $app->post('/controls/{id}', 'getControlAct')->name('controlActivity');
        $app->post('/gencontrols', 'genControl')->name('gencontrols');
        $app->get('api/v1/controls/{id}', 'getControlDet')->name('controlDet');
        $app->post('/approvecontrols', 'approveControl')->name('approvecontrol');
        $app->post('/approvecontrols_action', 'approveControlAct')->name('approvecontrol_activity');
        $app->get('api/v1/controls/activity/{id}', 'getControlActDet')->name('controlActivityDet');
        $app->post('/api/v1/controls/activity', 'editControlAct')->name('controlActivityEdit');
        $app->post('/api/v1/genissue_control', 'genIssueControl')->name('controlActivityGenIssue');
        $app->post('/api/v1/genkci', 'genKCI')->name('genkci');

        //Export Data
        $app->get('/export_controls', 'exportData')->name('export_controls');
    });

    //Audit---->
    Route::controller(AuditController::class)->group(function ($app) {
        $app->get('/audit', 'getView')->name('audit');
        $app->post('/audit', 'getView')->name('audit');
        $app->get('/audit_activity/{id}', 'getAuditAct')->name('auditActivity');
        $app->post('/audit_activity/{id}', 'getAuditAct')->name('auditActivity');
        $app->get('/api/v1/audit', 'getAuditDet')->name('auditDetails');
        $app->get('/api/v1/audit/{id}', 'getAuditDetId')->name('auditDetailsId');
        $app->get('/api/v1/audit_activity/{id}', 'getAuditActDetId')->name('auditActDetailsId');
        $app->post('/api/v1/addaudit', 'addAudit')->name('addaudit');
        $app->post('/api/v1/addauditact', 'addAuditAct')->name('addauditact');
        $app->post('/api/v1/genspecaudit', 'genSpecAudit')->name('genspecaudit');
        $app->post('/api/v1/editauditfinding', 'editAuditFinding')->name('editauditfinding');
        $app->post('/api/v1/editaudit', 'editAudit')->name('editaudit');

        $app->post('/approveaudit', 'approveAudit')->name('approveaudit');
        $app->post('/approveaudit_activity', 'approveAuditAct')->name('approveaudit_activity');

        $app->post('/deleteaudit', 'deleteAudit')->name('deleteaudit');
        $app->post('/deleteauditact', 'deleteAuditAct')->name('deleteauditact');

        //Export Data
        $app->get('/export_audit', 'exportData')->name('export_audit');
        $app->get('/export_auditact/{id}', 'exportDataAct')->name('export_auditact');
    });

    //Risk Register---->
    Route::controller(RegisterController::class)->group(function ($app) {
        $app->get('/risk_register', 'getRegister')->name('risk_register');
        $app->get('/risk_register_edit/{id}', 'getRegisterEdit')->name('risk_register_edit');
        $app->post('/risk_register_save/{id}', 'saveRegister')->name('risk_register_save');
        $app->post('api/v1/risk_register/generate', 'generateRisk')->name('generate_risk_register');
        $app->post('api/v1/risk_register_programs/{id}', 'genTreatStrategy')->name('risk_register_programs');
        $app->post('api/v1/risk_register/issue/generate/{id}', 'generateIssue')->name('risk_register_generate_issue');
    });

    //Report--------------------------------->
    //Report Overview---->
    Route::controller(ReportOverviewController::class)->group(function ($app) {
        $app->get('/overview', 'index')->name('overview');
    });

    //Report Risk------>
    Route::controller(ReportRiskController::class)->group(function ($app) {
        $app->get('/report_risk', 'index')->name('report_risk');
        $app->get('/report_risk/risk/objective', 'reportRiskObjective')->name('reportRiskObj');
        $app->get('/report_risk/treated/risk/objective', 'reportRiskTreatObjective')->name('reportRiskTreatedObj');
        $app->get('/report_risk/treated/level/before/objective', 'reportRiskBeforeObjective')->name('reportRiskLevelBfr');
        $app->get('/report_risk/treated/level/after/objective', 'reportRiskAfterObjective')->name('reportRiskLevelAfr');
    });

    //Report Compliance------>
    Route::controller(ReportComplianceController::class)->group(function ($app) {
        $app->get('/report_compliance', 'index')->name('report_compliance');
        $app->get('/report_compliance/obligate', 'reportObligation')->name('reportCompOb');
        $app->get('/report_compliance/fulfillment', 'reportFulfillment')->name('reportComFul');
    });

    //Report Governance------>
    Route::controller(ReportGovernanceController::class)->group(function ($app) {
        $app->get('/report_governance', 'index')->name('report_governance');
        $app->get('/report_governance/objectegory', 'reportObjectegory')->name('reportObjectegory');
        $app->get('/report_governance/objective/category', 'reportObjPerCate')->name('reportObjPerCate');
        $app->get('/report_governance/kpitarget/objective', 'reportKpiObj')->name('reportKpiObj');
        $app->get('/report_governance/kpitarget/achiev/objective', 'reportKpiAchevObj')->name('reportKpiAchevObj');
        $app->get('/report_governance/kpitarget/achiev/objectegory', 'reportKpiAchevObjCate')->name('reportKpiAchevObjCate');
    });

    //Report Control------>
    Route::controller(ReportControlController::class)->group(function ($app) {
        $app->get('/report_control', 'index')->name('report_control');
        $app->get('/report_control/detective/action', 'conReportDetectiAction')->name('reportConDecAct');
        $app->get('/report_control/detective/result', 'conReportDetectiResult')->name('reportConDecRes');
        $app->get('/report_control/detective/issue', 'conReportDetectiIssue')->name('reportConDecIsu');
        $app->get('/report_control/preventive/action', 'conReportPreventiAction')->name('reportConPreAct');
        $app->get('/report_control/preventive/result', 'conReportPreventiResult')->name('reportConPreRes');
        $app->get('/report_control/preventive/issue', 'conReportPreventiIssue')->name('reportConPreIsu');
        $app->get('/report_control/responsive/action', 'conReportResponAction')->name('reportConRespAct');
        $app->get('/report_control/responsive/result', 'conReportResponResult')->name('reportConRespRes');
        $app->get('/report_control/responsive/issue', 'conReportResponIssue')->name('reportConRespIsu');
    });

    //Report Issue------>
    Route::controller(ReportIssueController::class)->group(function ($app) {
        $app->get('/report_issue', 'index')->name('report_issue');
        $app->get('/report_issue/reported/issue', 'reportedIssue')->name('reportedIssue');
        $app->get('/report_issue/issue/resolved', 'reportIssueResolved')->name('issueResolved');
        $app->get('/report_issue/issue/not/resolved', 'reportIssueNotResolved')->name('issueNotResolved');
    });

    //Report Monev------>
    Route::controller(ReportMonevController::class)->group(function ($app) {
        $app->get('/report_monev', 'index')->name('report_monev');
        $app->get('/report_monev/nonconformity', 'reportMonevNonConformity')->name('reportMonevNonConformity');
        $app->get('/report_monev/area/for/improvement', 'reportMonevAreaImprove')->name('reportMonevAreaImprove');
        $app->get('/report_monev/recommendations', 'reportMonevRecommend')->name('reportMonevRecommend');
    });

    //Report Audit------>
    Route::controller(ReportAuditController::class)->group(function ($app) {
        $app->get('/report_audit', 'index')->name('report_audit');
        $app->get('/report_audit/control/effective', 'reportAuditConEffect')->name('reportAuditConEffect');
        $app->get('/report_audit/non/conformity', 'reportAuditNonConformity')->name('reportAuditNonConformity');
        $app->get('/report_audit/non/compliance', 'reportAuditNonCompliance')->name('reportAuditNonCompliance');
        $app->get('/report_audit/non/performance', 'reportAuditNonPerformance')->name('reportAuditNonPerformance');
        $app->get('/report_audit/area/for/improvement', 'reportAuditAreaImprove')->name('reportAuditAreaImprove');
        $app->get('/report_audit/recommend/improvement', 'reportAuditRecommend')->name('reportAuditRecommend');
    });

    // Test User Permission inside Group
    Route::get('/permissionstest', [GroupPermissionsController::class, 'test']);
    Route::get('/utilitytest', [GroupPermissionsController::class, 'test_utility']);
    Route::get('/utility', function () {
        Utility::echo();
    });
});
