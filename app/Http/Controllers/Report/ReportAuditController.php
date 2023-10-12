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

class ReportAuditController extends Controller
{
    public function index()
    {
        return view('pages.report.audit_report.index');
    }

    public function reportAuditConEffect()
    {
        return view('pages.report.audit_report.control_effective_audfind.index');
    }

    public function reportAuditNonConformity()
    {
        return view('pages.report.audit_report.non_conformity_audfind.index');
    }

    public function reportAuditNonCompliance()
    {
        return view('pages.report.audit_report.non_compliance_audfind.index');
    }

    public function reportAuditNonPerformance()
    {
        return view('pages.report.audit_report.non_performance_audfind.index');
    }

    public function reportAuditAreaImprove()
    {
        return view('pages.report.audit_report.area_for_improve.index');
    }

    public function reportAuditRecommend()
    {
        return view('pages.report.audit_report.recommend_improve.index');
    }
}
