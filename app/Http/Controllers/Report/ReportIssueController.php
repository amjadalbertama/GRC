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

class ReportIssueController extends Controller
{
    public function index()
    {
        return view('pages.report.issue_report.index');
    }

    public function reportedIssue()
    {
        return view('pages.report.issue_report.reported_issue.index');
    }

    public function reportIssueResolved()
    {
        return view('pages.report.issue_report.issue_been_resolved.index');
    }

    public function reportIssueNotResolved()
    {
        return view('pages.report.issue_report.issue_not_been_resolved.index');
    }
}
