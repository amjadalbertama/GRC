<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Compliance\ComplianceCategory;
use App\Models\Log;
use App\Library\Facades\Utility;
use App\Models\User;

class ReportGovernanceController extends Controller
{
    public function index()
    {
        return view('pages.report.governance_report.index');
    }

    public function reportObjectegory()
    {
        return view('pages.report.governance_report.objective_category.index');
    }

    public function reportObjPerCate()
    {
        return view('pages.report.governance_report.objective_per_category.index');
    }

    public function reportKpiObj()
    {
        return view('pages.report.governance_report.kpitarget_per_objective.index');
    }

    public function reportKpiAchevObj()
    {
        return view('pages.report.governance_report.kpitarget_achiev_objective.index');
    }

    public function reportKpiAchevObjCate()
    {
        return view('pages.report.governance_report.kpitarget_achiev_objectegory.index');
    }
}
