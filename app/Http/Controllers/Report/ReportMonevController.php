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

class ReportMonevController extends Controller
{
    public function index()
    {
        return view('pages.report.monev_report.index');
    }

    public function reportMonevNonConformity()
    {
        return view('pages.report.monev_report.non_conformity_or_behavior.index');
    }

    public function reportMonevAreaImprove()
    {
        return view('pages.report.monev_report.area_for_improvement.index');
    }

    public function reportMonevRecommend()
    {
        return view('pages.report.monev_report.recommendations.index');
    }
}
