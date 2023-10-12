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

class ReportRiskController extends Controller
{
    public function index()
    {
        return view('pages.report.risk_report.index');
    }

    public function reportRiskObjective()
    {
        return view('pages.report.risk_report.risk_per_objective.index');
    }

    public function reportRiskTreatObjective()
    {
        return view('pages.report.risk_report.treatedrisk_objective.index');
    }

    public function reportRiskBeforeObjective()
    {
        return view('pages.report.risk_report.treated_risk_lvlbefore_treatobj.index');
    }
    public function reportRiskAfterObjective()
    {
        return view('pages.report.risk_report.treated_risk_lvlafter_treatobj.index');
    }
}
