<?php

namespace App\Http\Controllers\Governances;

use App\Exports\Governances\kpiExprt;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\Control\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Governances\{
    Kpi,
    Kpiperiodend,
    Kpiperiod,
    Policies,
    PoliciesKpi,
    Organization,
    Capabilities
};
use App\Models\Log;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class KpiController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add kpi'),
            'view' => $userdata->hasPermission('view kpi'),
            'update' => $userdata->hasPermission('update kpi'),
            'delete' => $userdata->hasPermission('delete kpi'),
            'approval' => $userdata->hasPermission('approval kpi'),
            'reviewer' => $userdata->hasPermission('reviewer kpi'),
        ];

        $query = Kpi::query();
        $query->leftJoin('policies', 'policies.id', '=', 'kpi.id_policies');
        $query->leftJoin('organization', 'organization.id', '=', 'kpi.id_org');
        $query->leftJoin('capabilities', 'capabilities.id', '=', 'kpi.id_capabilities');
        $query->leftJoin('policies_kpi', 'policies_kpi.id', '=', 'kpi.id_policies_kpi');

        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }

        if (isset($request->status)) {
            $query->where("kpi.monitoring_status", $request->status);
        }

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(kpi.title LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'kpi.id',
            'kpi.monitoring_status',
            'kpi.total',
            'policies_kpi.indicators as title',
            'kpi.percentage',
            'policies_kpi.metric',
            'organization.name_org',
            'capabilities.description as business_outcome',
            'kpi.id_policies',
            'policies.title as policy',
            'policies.tolerance as tolerance_policies',
        );

        $kpi = $query
            ->orderBy("id", "DESC")
            ->paginate(10);
        $kpi_period_end = Kpiperiodend::get();
        $kpi_period = Kpiperiod::get();
        $policies = Policies::get();

        $audit_trails = Log::where('page', "KPI")->orderBy('created_at', 'asc')->get();

        $data_status_mappings = [
            [
                "id" => 1,
                "status" => "Within limit",
                "index_stat" => 0
            ],
            [
                "id" => 2,
                "status" => "Out of limit",
                "index_stat" => 1
            ],
        ];
        return view('pages.governance.kpi.index', [
            'kpi' => $kpi,
            'kpi_end' => $kpi_period_end,
            'kpi_period' => $kpi_period,
            'policies' => $policies,
            'audit_trails' => $audit_trails,
            'access' => $access,
            'status_mapping' => $data_status_mappings,
            'pagination' => json_decode(json_encode($kpi)),
        ]);
    }

    public function generateKpi(Request $request)
    {
        $user = Auth::user();

        $rq = $request->all();

        $checkKpi = Kpi::where('id_policies', $rq["id_policy"])->get();

        if (sizeof($checkKpi) != 0) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KPI dengan ID Policies ini sudah ada!",
            ]);
        }

        $getPolKpi = PoliciesKpi::where('id_policies', $rq["id_policy"])->get();

        if (sizeof($getPolKpi) == 0) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KPI dengan ID Policies ini belum ada!",
            ]);
        }

        $totalPercentage = 0;
        foreach ($getPolKpi as $keys => $prc) {
            $totalPercentage += $prc->percentage;
        }

        $arrKpi = [];
        $max = [];
        foreach ($getPolKpi as $key => $polKpi) {
            $getPolicies = Policies::where("id", $polKpi->id_policies)->first();

            $dataToKpi = [
                "id_policies" => $polKpi->id_policies,
                "id_policies_kpi" => $polKpi->id,
                "id_capabilities" => $getPolicies->id_bizenv,
                "id_org" => $user->org_id,
                "title" => $polKpi->indicators,
                "metric" => $polKpi->metric,
                "period" => $polKpi->period,
                "percentage" => $polKpi->percentage,
                "total" => $totalPercentage,
                "created_at" => date("Y-m-d H:i:s"),
            ];
            array_push($arrKpi, $dataToKpi);
            array_push($max, $polKpi->period);
        }

        $respKpiPeriodEnd = [];
        if (sizeof($arrKpi) > 0) {
            $getIdKpi = Kpi::insert($arrKpi);

            if ($getIdKpi == true) {
                $getKPI = Kpi::where('id_policies', $rq["id_policy"])->get();

                $data_kpi_period = [];
                for ($i = 0; $i < sizeof($getKPI); $i++) {
                    for ($n = 0; $n < $getKPI[$i]->period; $n++) {
                        $m = $n + 1;
                        $data_kpi_period[] = array(
                            'kpi_id' => $getKPI[$i]->id,
                            'periods' => 'Period ' . $m,
                            'target' => 0,
                            'actual' => 0,
                            'score' => 0,
                            'end' => 0,
                        );
                    }
                }

                // print_r(json_encode($data_kpi_period));
                $resKpiPeriod = Kpiperiod::insert($data_kpi_period);

                if ($resKpiPeriod == true) {
                    foreach ($getKPI as $keyz => $kpi) {
                        $data_kpi_period_end = array(
                            "kpi_id" => $kpi->id,
                            "target_period_end" => 0,
                            "actual_period_end" => 0,
                            "score_period_end" => 0,
                            "end_period_end" => 0,
                        );
                        $resKpiPeriodEnd = Kpiperiodend::create($data_kpi_period_end);

                        array_push($respKpiPeriodEnd, $resKpiPeriodEnd);
                    }
                }
            }

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 2)
                ->get();
            $status = 'GENERATED';

            foreach ($email as $data) {
                Utility::notif("KPI", $request, $data, $status);
            }

            Utility::log("KPI", $user, $kpi->id, $email, "GENERATED");

            if (sizeof($respKpiPeriodEnd) > 0) {
                return response()->json([
                    "success" => true,
                    "data" => $respKpiPeriodEnd,
                    "message" => "Data KPI berhasil di generate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => $respKpiPeriodEnd,
                    "message" => "Data KPI gagal di generate!",
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KPI gagal di generate!",
            ]);
        }
    }

    public function detailsKpi($id)
    {
        $getPerKpi = json_decode(json_encode(Kpi::where('id', $id)->first()), true);
        $getPolicies = json_decode(json_encode(Policies::where('id', $getPerKpi['id_policies'])->first()), true);
        $getCapab = json_decode(json_encode(Capabilities::where('id', $getPerKpi['id_capabilities'])->select('description as business_outcome')->first()), true);
        $getOrg = json_decode(json_encode(Organization::where('id', $getPerKpi['id_org'])->first()), true);
        $kpi_period_end = Kpiperiodend::where('kpi_id', $id)->get();
        $kpi_period = Kpiperiod::where('kpi_id', $id)->get();
        $getCekIssue = json_decode(json_encode(Issue::where('id_kpi', $id)->first()), true);

        $dataPolicies["policiest"] = $getPolicies;
        $dataCapab["capabilitiesr"] = $getCapab;
        $dataOrg["organizations"] = $getOrg;

        $array_kpi = array_merge($getPerKpi, $dataPolicies, $dataCapab, $dataOrg);

        if (isset($array_kpi['id'])) {
            return response()->json([
                "success" => true,
                "data" => $array_kpi,
                "periodkpi" => $kpi_period,
                "periodKpiEnd" => $kpi_period_end,
                "cekIssue" => $getCekIssue,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "periodkpi" => [],
                "periodKpiEnd" => [],
                "cekIssue" => [],
            ]);
        }
    }
    public function editPeriodKpi(Request $request)
    {

        $user = Auth::user();
        $rq = $request->all();
        $insPerKpi = Kpiperiod::where('id', $rq["id_periodKpi"])->first();
        // dd($insPerKpi);
        if (!intval($rq["target_kpi"]) || !intval($rq["actual_kpi"])) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Mohon Isi kolom Target dan Actual, Data yg diinput harus berupa Angka!",
            ]);
        } elseif ($rq["target_kpi"] > 100) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Please fill in the column Target and Actual Target dan Actual,
                the data entered in the Target column is a maximum of 100%!",
            ]);
        } else {
            $dataKpi = [
                'id' => $insPerKpi->id,
                'kpi_id' => $insPerKpi->kpi_id,
                'periods' => $insPerKpi->periods,
                'target' => $rq["target_kpi"],
                'actual' => $rq["actual_kpi"],
                'score' => $rq["score_kpi"],
                'end' => $rq["end_kpi"],
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $tom = Kpiperiod::where("id", $rq["id_periodKpi"])->update($dataKpi);
        }


        // $status = 'PERIOD KPI UPDATED';
        // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
        //     ->where('roles.id', 2)
        //     ->get();
        // foreach ($email as $data) {
        //     Utility::notif("KPI", $request, $data, $status);
        // }

        // Utility::log("KPI", $user, $tom->id, $email, $status);
        if ($tom == 1) {
            $newperiodkpi = Kpiperiod::where('id', $rq["id_periodKpi"])->first();
            return response()->json([
                "success" => true,
                "data" => $newperiodkpi,
                "message" => "Berhasil menambahkan Period KPI di Policies!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Gagal menambahkan Period KPI di Policies!",
            ]);
        }
    }

    public function editPeriodKpiEnd(Request $request)
    {
        $rq = $request->all();
        $user = Auth::user();
        $insPerKpi = Kpiperiodend::where('id', $rq["id_periodKpi"])->first();

        if ($rq["target_kpi"] > 100 || $rq["actual_kpi"] > 100) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Mohon Isi kolom Target dan Actual, Data yg diinput harus berupa Angka dgn Max 100%!",
            ]);
        } else {
            $dataKpi = [
                'id' => $insPerKpi->id,
                'kpi_id' => $insPerKpi->kpi_id,
                'target_period_end' => $rq["target_kpi"],
                'actual_period_end' => $rq["actual_kpi"],
                'score_period_end' => $rq["score_kpi"],
                'end_period_end' => $rq["end_kpi"],
                'created_at' => date("Y-m-d H:i:s"),
            ];
            // dd($dataKpi);
            $tom = Kpiperiodend::where("id", $rq["id_periodKpi"])->update($dataKpi);
        }



        // $status = 'PERIOD KPI END UPDATED';

        // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
        //     ->where('roles.id', 2)
        //     ->get();
        // foreach ($email as $data) {
        //     Utility::notif("KPI", $request, $data, $status);
        // }

        // Utility::log("KPI", $user, $insPerKpi->id, $email, $status);
        if ($tom == 1) {
            $newperiodkpi = Kpiperiodend::where('id', $rq["id_periodKpi"])->first();
            return response()->json([
                "success" => true,
                "data" => $newperiodkpi,
                "message" => "Berhasil menambahkan Period KPI di Policies!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Gagal menambahkan Period KPI di Policies!",
            ]);
        }
    }

    public function saveStatKpi(Request $request, $id)
    {
        $rq = $request->all();

        $user = Auth::user();

        if ($rq['statusKpi'] == 0) {
            $monitoring_status = "Within limit";
            $status = 'STATUS UPDATED To WITHIN LIMIT';
            $tolerance = "";
        } elseif ($rq['statusKpi']  == 1) {
            if ($rq['toleranceKpi'] == 0) {
                $tolerance = "Tolerable";
            } else {
                $tolerance = "Non Tolerable";
            }
            $monitoring_status = "Out of limit";
            $status = 'STATUS UPDATED To OUT OF LIMIT';
        }

        $updateKpiStatus = [
            'monitoring_status' => $monitoring_status,
            'tolerance' => $tolerance,
        ];

        $email = User::join('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.id', 2)
            ->get();


        foreach ($email as $data) {
            Utility::notif("KPI", $request, $data, $status);
        }

        Utility::log("KPI", $user, $id, $email, $status);

        $updkpi = Kpi::where('id', $id)->update($updateKpiStatus);
        if ($updkpi == 1) {
            return response()->json([
                "success" => true,
                "message" => "Berhasil Update Status Monitoring KPI!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Gagal Update Status Monitoring KPI!",
            ]);
        }
    }

    public function generateKpiIssue(Request $request, $id)
    {
        $getKpi = Kpi::where("id", $id)->first();

        if (!isset($request->title)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Title / Notes is required!",
            ]);
        } elseif ($request->title == "" || $request->title == null) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Please input your Title / Notes first!",
            ]);
        }

        if ($request->monstat == 0) {
            $monitoring_status = "Within limit";
        } elseif ($request->monstat  == 1) {
            $monitoring_status = "Out of limit";
        }

        if ($request->tolerance == 0) {
            $tolerance = "Tolerable";
        } elseif ($request->tolerance  == 1) {
            $tolerance = "Non Tolerable";
        }

        $updateKpiStatus = [
            'monitoring_status' => $monitoring_status,
            'tolerance' => $tolerance
        ];
        Kpi::where('id', $id)->update($updateKpiStatus);

        $dataIssue = [
            "id_kpi" => $id,
            "title" => $request->title,
            "id_org" => $getKpi->id_org,
            "followup_status" => 1,
            "type" => 1,
            "information_source" => 7,
            "created_at" => date("Y-m-d H:i:s"),
        ];

        try {
            $genIssue = Issue::create($dataIssue);

            if (isset($genIssue->id)) {
                return response()->json([
                    "success" => true,
                    "data" => $genIssue,
                    "message" => "Issue berhasil di generate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Issue Gagal di generate!",
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function confirmKpi($id)
    {
        $getkpi  = Kpi::where('id', $id)->first();
        if (isset($getkpi->id)) {
            return response()->json([
                "success" => true,
                "data" => $getkpi,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function deleteKpi(Request $request, $id)
    {
        $rq = $request->all();
        if (!empty($rq['reasonKpi'])) {
            $delkpi = Kpi::where('id', $id)->delete();
            $delkpiperiod = Kpiperiod::where('kpi_id', $id)->delete();
            $delkpiperiodend = Kpiperiodend::where('kpi_id', $id)->delete();
            return response()->json([
                "success" => true,
                "message" => "KPI data has been Deleted!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Reason Can't Empty!",
            ]);
        }
    }

    public function exportData()
    {

        $query = Kpi::query();
        $query->leftJoin('policies', 'policies.id', '=', 'kpi.id_policies');
        $query->leftJoin('organization', 'organization.id', '=', 'kpi.id_org');
        $query->select(
            'kpi.id',
            'kpi.monitoring_status',
            'kpi.title',
            'organization.name_org',
            'kpi.id_policies',
            'policies.title as policy',
        );

        $kpi = $query->orderBy("id", "ASC")->get();

        return Excel::download(new kpiExprt($kpi), 'Kpi-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
