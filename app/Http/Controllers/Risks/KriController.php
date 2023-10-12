<?php

namespace App\Http\Controllers\Risks;

use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\{
    Log,
    User,
};
use App\Models\Control\Issue;
use App\Models\Risks\{
    Kri,
    RiskRegisters as RR,
    RiskRegisterIdentifications as Identifications,
    RiskRegisterMonitorings as Monitoring,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KriController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add kri'),
            'view' => $userdata->hasPermission('view kri'),
            'update' => $userdata->hasPermission('update kri'),
            'delete' => $userdata->hasPermission('delete kri'),
            'approval' => $userdata->hasPermission('approval kri'),
            'reviewer' => $userdata->hasPermission('reviewer kri'),
        ];

        $query = Kri::query();
        $query->leftJoin('objective', 'objective.id', '=', 'kri.obj_id');
        $query->leftJoin('risk_register_identifications', 'risk_register_identifications.id_risk_register', '=', 'kri.id_risk_register');
        $query->leftJoin('organization', 'organization.id', '=', 'objective.id_organization');
        if (isset($request->search_data)) {
            $query->where("kri.kri", "LIKE", "%" . $request->search_data . "%");
        }
        if ($user->org_id != 0) {
            $query->where('objective.id_organization', $user->org_id);
        }
        $query->select('kri.id', 'kri.kri', 'kri.monitor_status', 'objective.id as obj_id', 'objective.smart_objectives', 'risk_register_identifications.risk_event_event', 'organization.name_org');
        $KRI = $query
            ->orderBy("id", "DESC")
            ->paginate(10);

        $audit_trails = Log::where('page', "KRI")->orderBy('created_at', 'asc')->get();

        return view('pages.risk.kri.index', ['kri' => $KRI, 'access' => $access, 'audit_trails' => $audit_trails]);
    }

    public function getKri($id)
    {
        $KriGet = Kri::leftJoin('objective', 'objective.id', '=', 'kri.obj_id')
            ->leftJoin('risk_register_identifications', 'risk_register_identifications.id_risk_register', '=', 'kri.id_risk_register')
            ->leftJoin('organization', 'organization.id', '=', 'objective.id_organization')
            ->where('kri.id', $id)
            ->select('kri.id', 'kri.kri', 'kri.kri_parameter', 'kri.kri_upper', 'kri.kri_lower', 'kri.monitor_status', 'objective.smart_objectives', 'risk_register_identifications.risk_event_event', 'risk_register_identifications.risk_event_category')
            ->first();

        $toJsonKri = json_encode($KriGet);
        $Kri = json_decode($toJsonKri);

        $getCekIssue = Issue::where('id_kri', $id)->first();
        if (isset($KriGet->kri)) {
            return response()->json([
                "success" => true,
                "data" => $Kri,
                "cekIssue" => $getCekIssue,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "cekIssue" => [],
            ]);
        }
    }

    public function editKri(Request $request, $id)
    {
        $user = Auth::user();
        $rq = $request->all();

        $check_kri = Kri::where('id', $id)->first();

        if (!isset($check_kri->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KRI Tidak Ditemukan!",
            ]);
        }

        try {

            DB::beginTransaction();
            if ($rq['statusKri'] == 0) {
                $monStat = "Within Limit";
            } else {
                $monStat = "Out Of Limit";
            }
            $update_data = [
                "monitor_status" => $monStat,
            ];

            $update = Kri::where('id', $id)->update($update_data);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("KRI", $request, $data, "UPDATED");
            }

            Utility::log("KRI", $user, $id, $email, "UPDATED");

            return response()->json([
                "success" => true,
                "data" => $update,
                "message" => "Berhasil update KRI!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Gagal update KRI!",
            ]);
        }
    }

    public function generateKri(Request $request)
    {
        $getRr = RR::where("id", $request->id_risk_register)->first();
        $getRiskRegIde = Identifications::where("id_risk_register", $request->id_risk_register)->first();
        $getRiskRegMon = Monitoring::where("id_risk_register", $request->id_risk_register)->first();

        $monStat = [
            "Out of limit",
            "Within limit",
        ];

        if (isset($getRiskRegIde->kri) && $getRiskRegIde->is_kri == 1) {
            if ($getRiskRegIde->kri_parameter == null || $getRiskRegIde->kri_lower == null || $getRiskRegIde->kri_upper == null) {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Field Paramater, Upper atau Lower tidak boleh kosong! Silakan isi field tersebut terlebih dulu.",
                ]);
            }


            $statusMonitoring = "";

            if (isset($getRiskRegMon->risk_monitoring_status)) {
                for ($i = 0; $i <= sizeof($monStat); $i++) {
                    if ($getRiskRegMon->risk_monitoring_status == $i) {
                        $statusMonitoring = $monStat[$i];
                    }
                }
            } else {
                $statusMonitoring = $monStat[1];
            }

            $dataReqKri = [
                "kri" => $getRiskRegIde->kri,
                "kri_parameter" => $getRiskRegIde->kri_parameter,
                "kri_lower" => $getRiskRegIde->kri_lower,
                "kri_upper" => $getRiskRegIde->kri_upper,
                "obj_id" => $getRr->id_objective,
                "id_risk_register" => $getRr->id,
                "monitor_status" => $statusMonitoring,
            ];

            $insKri = Kri::create($dataReqKri);

            if (isset($insKri->id)) {
                return response()->json([
                    "success" => true,
                    "data" => $insKri,
                    "message" => "Berhasil generate KRI!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Gagal generate KRI!",
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Anda belum menyimpan Risk Register, simpan Risk Register terlebih dulu!",
            ]);
        }
    }

    public function deleteKri(Request $request, $id)
    {
        $rq = $request->all();

        $check_kri = Kri::where('id', $id)->first();

        if (!isset($check_kri->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "KRI is not Found!",
            ]);
        } else {
            try {
                if (isset($rq['reasonKri'])) {
                    $deleteDataKri = Kri::where('id', $id)->delete();
                    return response()->json([
                        "success" => true,
                        "data" => $deleteDataKri,
                        "message" => "Delete Kri Success!",
                    ]);
                } else {
                    return response()->json([
                        "success" => false,
                        "data" => [],
                        "message" => "Reason don't Empty!",
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
    }

    public function genIssueKri(Request $request, $id)
    {
        $getKri = Kri::where("id", $id)->first();

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

        if ($request->monitorstatkri == 0) {
            $monitoring_status = "Within limit";
        } elseif ($request->monitorstatkri  == 1) {
            $monitoring_status = "Out of limit";
        }

        $updateKpiStatus = [
            'monitor_status' => $monitoring_status
        ];

        Kri::where('id', $id)->update($updateKpiStatus);

        $dataIssue = [
            "id_kri" => $id,
            "title" => $request->title,
            "id_org" => $getKri->id_org,
            "followup_status" => 1,
            "type" => 1,
            "information_source" => 9,
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
}
