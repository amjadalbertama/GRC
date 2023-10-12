<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\Facades\Utility;
use App\Models\Compliance\ComplianceRegister;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Objective,
    Objectegory,
    RiskIdentification,
    Log,
    User,
    RiskAppetite,
    KpiObjective,
    Environment,
};
use App\Models\General\{
    StatusMapping as Status,
    ReviewLogs as Review,
};
use App\Models\Governances\{
    Kpi,
    Organization,
    Periods,
    Kpiperiod,
    TypeGovernances,
};
use App\Models\Risks\{
    RiskRegisters as RR,
};
use App\Exports\Governances\ObjectiveExport as OBJ;
use Maatwebsite\Excel\Facades\Excel;

class ObjectiveController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();
        $access = [
            'add' => $userdata->hasPermission('add objective'),
            'view' => $userdata->hasPermission('view objective'),
            'update' => $userdata->hasPermission('update objective'),
            'delete' => $userdata->hasPermission('delete objective'),
            'approval' => $userdata->hasPermission('approval objective'),
            'reviewer' => $userdata->hasPermission('reviewer objective'),
        ];

        $query = Objective::query();

        if (isset($request->search_data)) {
            $query->where("smart_objectives", "LIKE", "%".$request->search_data."%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $dataobjective = $query->where('id_organization', $user->org_id)->orderBy("id", "DESC")->paginate(10)->toArray();
            $data_kpi = Kpi::where('id_org', $user->org_id)->get();
        } else {
            $dataobjective = $query->orderBy("id", "DESC")->paginate(10)->toArray();
            $data_kpi = Kpi::get();
        }

        $arrObjective = [];
        foreach ($dataobjective['data'] as $ob) {
            $riskIdent = RiskIdentification::where("id_objective", $ob['id'])->get()->toArray();
            $kpi_obj = KpiObjective::where("id_objective", $ob['id'])->get()->toArray();
            $getRA = RiskAppetite::where("id_objective", $ob["id"])->first();
            $getStatus = Status::where("id", $ob["status"])->first();
            $getPeriod = Periods::where("id", $ob['id_period'])->first();
            $getObjCat = Objectegory::where("id", $ob['id_category'])->first();
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Objective")->where("module_id", $ob["id"])->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get();

            $resultsIden = [
                "id" => $ob['id'],
                'smart_objectives' => $ob['smart_objectives'],
                'id_category' => $ob['id_category'],
                'category' => isset($getObjCat->title) ? $getObjCat : ["id" => 0, "title" => "-"],
                'id_period' => $ob['id_period'],
                'period' => $getPeriod,
                'criteria' => $ob['criteria'],
                'status' => $ob['status'],
                'status_mapping' => $getStatus,
                'notes' => $getReview,
                "risk_appetite" => $getRA,
                'id_organization' => $ob['id_organization'],
                "risk_identifications" => [],
                "kpi" => [],
            ];
            foreach ($riskIdent as $key => $ri) {
                $getRR = RR::where("id_objective", $ob['id'])->where("id_risk_identification", $ri["id"])->first();
                $getCompliance = ComplianceRegister::where('objective_id', $ob['id'])->first();
                $dataRi = [
                    "id" => $ri["id"],
                    "id_objective" => $ri["id_objective"],
                    "risk_compliance_sources" => $ri["risk_compliance_sources"],
                    "type" => $ri["type"],
                    "risk_event" => $ri["risk_event"],
                    "risk_register" => $getRR,
                    "compliance_register" => $getCompliance,
                    "created_at" => $ri["created_at"],
                ];
                array_push($resultsIden["risk_identifications"], $dataRi);
            }
            foreach ($kpi_obj as $key => $ko) {
                $dataKpi = [
                    "id" => $ko["id"],
                    "id_objective" => $ko["id_objective"],
                    "id_kpi" => $ko["id_kpi"],
                    "kpi" => $ko["kpi"],
                    "percentage" => $ko["percentage"],
                    "period" => $ko["period"],
                    "metric" => $ko["metric"],
                ];
                array_push($resultsIden["kpi"], $dataKpi);
            }
            array_push($arrObjective, $resultsIden);
        }
        $toJson = json_encode($arrObjective);
        $objective = json_decode($toJson);

        $data_periods = Periods::where('org_id', $user->org_id)->where('status', 5)->get();
        $objectegory = Objectegory::where("id_organization", "=", 0)->orWhere("id_organization", $user->org_id)->where("status", "=", 5)->get();

        $data_audit_trails = Log::where('page', "Objective")->orderBy('created_at', 'asc')->get();
        $data_organization = Organization::get();
        $data_status_mapping = Status::get();
        $data_type_governance = TypeGovernances::get();
        $data_biz_environment = Environment::get();

        return view('pages.governance.objectives.index')
            ->with('objective', $objective)
            ->with('objectegory', $objectegory)
            ->with('audit_trails', $data_audit_trails)
            ->with('status_mapping', $data_status_mapping)
            ->with('kpi', $data_kpi)
            ->with('biz_environment', $data_biz_environment)
            ->with('type_governance', $data_type_governance)
            ->with('organization', $data_organization)
            ->with('access', $access)
            ->with('periods', $data_periods)
            ->with('pagination', json_decode(json_encode($dataobjective)));
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        $dataInput = [
            'smart_objectives' => $request->smart_objectives,
            'id_category' => $request->id_category,
            'id_organization' => $user->org_id,
            'id_period' => $request->id_period,
            'criteria' => $request->criteria,
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s"),
        ];
        // $makeDataObj = DB::table("objective")->create($dataInput);
        $makeDataObj = Objective::create($dataInput);

        if (isset($makeDataObj->id)) {
            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            if (sizeof($email) != 0) {
                foreach ($email as $data) {
                    Utility::notif("Objective", $request, $data, "CREATED");
                }

                Utility::log("Objective", $user, (int)$makeDataObj->id, $email, "CREATED");
            }
            
            return redirect('objective')->with('addorg', 'Data Objective berhasil ditambahkan.');
        } else {
            return redirect('objective')->with('addorg', 'Data Objective gagal ditambahkan.');
        }
    }

    public function addriskident(Request $request)
    {
        $rq = $request->all();

        $dataRE = [
            'risk_compliance_sources' => $rq['risk_compliance_sources'],
            'type' => $rq['type'],
            'id_objective' => $rq['id_objective'],
            'risk_event' => $rq['risk_event'],
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $insRE = RiskIdentification::create($dataRE);

        if (isset($insRE->id)) {
            return response()->json([
                "success" => true,
                "data" => $insRE,
                "message" => "Berhasil menambahkan KPI di Policies!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Gagal menambahkan KPI di Policies!",
            ]);
        }
    }

    public function addkpi(Request $request)
    {
        $rq = $request->all();

        $dataKpi = [
            'kpi' => $rq['kpi_title'],
            'id_kpi' => $rq['id_kpi'],
            'percentage' => $rq['percentage'],
            'metric' => $rq['metric'],
            'id_objective' => $rq['id_objective'],
            'period' => $rq["period"],
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $insRE = KpiObjective::create($dataKpi);

        if (isset($insRE->id)) {
            $getKpiObj = KpiObjective::where("id_objective", $insRE->id_objective)->get()->toArray();

            if (sizeof($getKpiObj) != 0) {
                $achievements = [];
                foreach ($getKpiObj as $key => $kpiObj) {
                    $getKpiPeriods = Kpiperiod::select("end")->where("kpi_id", $kpiObj["id_kpi"])->get()->max()->toArray();

                    array_push($achievements, $getKpiPeriods["end"]);
                }

                $kpi_period_end = array_sum($achievements);

                if ($kpi_period_end == 100) {
                    $updObj = Objective::where("id", $insRE->id_objective)->update([
                        "achievements" => 1,
                    ]);
                }
            }

            return response()->json([
                "success" => true,
                "data" => $insRE,
                "message" => "Berhasil menambahkan KPI di Objective!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Gagal menambahkan KPI di Objective!",
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'smart_objectives' => $request->smart_objectives,
            'id_category' => $request->id_category,
            'id_period' => $request->id_period,
            'criteria' => $request->criteria,
            // 'notes' => $request->notes,
            'status' => 3,
        ];

        $updObj = Objective::where('id', $id)->update($dataUpdate);

        if ($updObj == 1) {
            return redirect('objective')->with('update', 'Data Objective berhasil diperbarui.');
        } else {
            return redirect('objective')->with('update', 'Data Objective gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        DB::table('objective')->where('id', $id)->delete();
        return redirect('objective')->with('delete', 'Data Objective berhasil dihapus.');
    }

    public function approval(Request $request, $id)
    {
        $user = Auth::user();
        try {
            DB::beginTransaction();

            if ($request->input('action') == 'approve') {
                if ($user->role_id == 3) {
                    $status = 7;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('roles.id', 4)
                        ->get();
                } elseif ($user->role_id == 4) {
                    $status = 4;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('roles.id', 5)
                        ->get();
                } elseif ($user->role_id == 5) {
                    $status = 5;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('users.org_id', $user->org_id)
                        ->where('roles.id', 2)
                        ->get();
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];

                Objective::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Objective", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Objective", $request, $data, "APPROVED");
                }

                Utility::log("Objective", $user, $id, $email, "APPROVEDS");
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                Objective::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Objective", $id, $user, $request->revnotes, "Recheck");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Objective", $request, $data, "REJECTED");
                }

                Utility::log("Objective", $user, $id, $email, "REJECTED");
            }
            return redirect('objective')->with('approve', 'Data objective berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('objective')->with('approve', 'Data objective gagal diupdate.');
        }
    }
    public function getBiz(Request $request)
    {
        $r = $request->all();

        $getbizbyperiod = Environment::where('period', $r["id_period"])->get();

        if (sizeof($getbizbyperiod) != 0) {
            return response()->json([
                "success" => true,
                "data" => $getbizbyperiod,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function getkpi($id)
    {
        $getkpi = Kpi::where('id', $id)->get();

        $kpi = kpi::select(
            'kpi.id',
            'kpi.percentage',
            'kpi.metric',
            'kpi.title',
            DB::raw('COUNT(kpi.id) As total_periods')
        )
            ->leftJoin('kpi_periods', 'kpi_periods.kpi_id', '=', 'kpi.id')
            ->groupBy('kpi.id', 'kpi.percentage', 'kpi.metric', 'kpi.title')
            ->where('kpi.id', $id)
            ->first();

        // print_r(json_encode($kpi));die;
        $be_array = array($kpi);

        if (sizeof($be_array) != 0) {
            return response()->json([
                "success" => true,
                "data" => $be_array,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function getKpiObj($id)
    {
        $getObjKpi = KpiObjective::where("id", $id)->first();

        if (isset($getObjKpi->id)) {
            return response()->json([
                "success" => true,
                "data" => $getObjKpi,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getObjKpi,
                "message" => "Data KPI Objective tidak ada!",
            ]);
        }
        
    }

    public function delKpiObj($id)
    {
        $delObjKpi = KpiObjective::where("id", $id)->delete();

        if ($delObjKpi == 1) {
            return response()->json([
                "success" => true,
                "data" => $delObjKpi,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $delObjKpi,
                "message" => "Data KPI Objective tidak ada!",
            ]);
        }
    }

    public function delRiskIdentification($id)
    {
        $delRiskIden = RiskIdentification::where("id", $id)->delete();

        if ($delRiskIden == 1) {
            return response()->json([
                "success" => true,
                "data" => $delRiskIden,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $delRiskIden,
                "message" => "Data KPI Objective tidak ada!",
            ]);
        }   
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $user = Auth::user();

        $query = Objective::query();

        if (isset($request->search_data)) {
            $query->where("smart_objectives", "LIKE", "%".$request->search_data."%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where('id_organization', $user->org_id);
        }

        $dataobjective = $query->get()->toArray();

        $arrObjective = [];
        foreach ($dataobjective as $ob) {
            $getStatus = Status::where("id", $ob["status"])->first();
            $getObjCat = Objectegory::where("id", $ob['id_category'])->first();
            $getOrg = Organization::where("id", $ob['id_organization'])->first();

            $resultsIden = [
                "id" => $ob['id'],
                'smart_objectives' => $ob['smart_objectives'],
                'category' => isset($getObjCat->title) ? $getObjCat : ["id" => 0, "title" => "-"],
                'status_mapping' => $getStatus,
                'organization' => $getOrg,
            ];
            array_push($arrObjective, $resultsIden);
        }
        $toJson = json_encode($arrObjective);
        $objective = json_decode($toJson);

        return Excel::download(new OBJ($objective), 'objective-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
