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

class ReportComplianceController extends Controller
{
    public function index()
    {
        return view('pages.report.compliance_report.index');
    }

    public function reportObligation()
    {
        return view('pages.report.compliance_report.compliance_obligations_bispro.index');
    }

    public function reportFulfillment()
    {
        return view('pages.report.compliance_report.compliance_fulfillment_bispro.index');
    }
}
