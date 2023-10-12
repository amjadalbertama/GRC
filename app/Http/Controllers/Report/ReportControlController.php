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

class ReportControlController extends Controller
{
    public function index()
    {
        return view('pages.report.control_report.index');
    }

    public function conReportDetectiAction()
    {
        return view('pages.report.control_report.detective_control_actions.index');
    }

    public function conReportDetectiResult()
    {
        return view('pages.report.control_report.detective_control_result.index');
    }

    public function conReportDetectiIssue()
    {
        return view('pages.report.control_report.detective_control_issue_reported.index');
    }

    public function conReportPreventiAction()
    {
        return view('pages.report.control_report.preventive_control_actions.index');
    }

    public function conReportPreventiResult()
    {
        return view('pages.report.control_report.preventive_control_result.index');
    }

    public function conReportPreventiIssue()
    {
        return view('pages.report.control_report.preventive_control_issue_reported.index');
    }

    public function conReportResponAction()
    {
        return view('pages.report.control_report.responsive_control_actions.index');
    }

    public function conReportResponResult()
    {
        return view('pages.report.control_report.responsive_control_result.index');
    }

    public function conReportResponIssue()
    {
        return view('pages.report.control_report.responsive_control_Issue_reported.index');
    }
}
