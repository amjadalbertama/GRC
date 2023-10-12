<?php

namespace App\Http\Controllers\Control;

use App\Exports\Controls\KciExprt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Library\Facades\Utility;
use App\Models\Control\Controls;
use App\Models\Control\ControlsActivity;
use App\Models\Control\Issue;
use App\Models\Control\Kci;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Isset_;

class KciController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add kci'),
            'view' => $userdata->hasPermission('view kci'),
            'update' => $userdata->hasPermission('update kci'),
            'delete' => $userdata->hasPermission('delete kci'),
            'approval' => $userdata->hasPermission('approval kci'),
            'reviewer' => $userdata->hasPermission('reviewer kci'),
        ];

        $query = Kci::query();
        $query->leftJoin('organization', 'organization.id', '=', 'kci.id_org');
        $query->leftJoin('controls_activity', 'controls_activity.id', '=', 'kci.id_control_activity');
        $query->leftJoin('controls', 'controls.id', '=', 'controls_activity.id_control');
        $query->leftJoin('programs', 'programs.id', '=', 'controls.id_program');

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(kci.title LIKE '%" . $rq["search_name"] . "%')");
        }

        if (isset($request->status)) {
            $query->where("kci.monitoring_status", $request->status);
        }

        if (isset($request->info)) {
            $query->where("kci.monitoring_status", $request->info);
        }

        if (isset($request->status)) {
            $query->where("kci.monitoring_status", $request->status);
        }

        $query->select(
            'kci.id',
            'kci.monitoring_status',
            'controls_activity.id as id_control_activity',
            'kci.title as kci_name',
            'controls_activity.threshold_lower',
            'controls_activity.threshold_upper',
            'controls.id as id_control',
            'programs.id as id_program',
            'programs.program_title',
            'organization.id as id_org',
            'organization.name_org',
        );

        $kci = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $audit_trails = Log::where('page', "Compliance Category")->orderBy('created_at', 'asc')->get();
        $data_status_mappings = [
            [
                "id" => 1,
                "status" => "Within limit",
                "style" => "text-body",
                "index_stat" => 0
            ],
            [
                "id" => 2,
                "status" => "Out of limit",
                "style" => "text-danger",
                "index_stat" => 1
            ],
        ];
        return view('pages.control.kci.index', [
            'kci' => $kci,
            'access' => $access,
            'audit_trails' => $audit_trails,
            'user' => $user,
            'status_mapping' => $data_status_mappings,
        ]);
    }

    public function detailskci($id)
    {
        $getkci = Kci::leftJoin('organization', 'organization.id', '=', 'kci.id_org')
            ->leftJoin('controls_activity', 'controls_activity.id', '=', 'kci.id_control_activity')
            ->leftJoin('controls', 'controls.id', '=', 'controls_activity.id_control')
            ->leftJoin('programs', 'programs.id', '=', 'controls.id_program')
            ->where('kci.id', $id)
            ->select(
                'kci.id',
                'kci.monitoring_status',
                'controls_activity.id as id_control_activity',
                'controls_activity.activity_kci as kci_name',
                'controls_activity.threshold_lower',
                'controls_activity.threshold_upper',
                'controls.id as id_control',
                'programs.id as id_program',
                'programs.program_title',
                'organization.id as id_org',
                'organization.name_org',
            )->first();
        $getCekIssue = Issue::where('id_kci', $id)->first();

        if (isset($getkci->id)) {
            return response()->json([
                "success" => true,
                "data" => $getkci,
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

    public function savestatus(Request $request, $id)
    {
        $user = Auth::user();
        $rq = $request->all();

        if ($rq['statusKci'] == 0) {
            $monStat = "Within limit";
        } elseif ($rq['statusKci'] == 1) {
            $monStat = "Out of limit";
        }

        $updatedata = [
            "monitoring_status" => $monStat,
        ];

        $update = Kci::where('id', $id)->update($updatedata);
        // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
        //     ->where('users.org_id', $user->org_id)
        //     ->where('roles.id', 3)
        //     ->get();
        // Utility::log("KCI", $user, $id, $email, "UPDATED");
        if ($update == 1) {
            return response()->json([
                "success" => true,
                "message" => "Berhasil update KCI!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Gagal update KCI!",
            ]);
        }
    }


    public function generateIssueKci(Request $request, $id)
    {
        $getKci = Kci::where("id", $id)->first();

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

        if ($request->statusKci == 0) {
            $monitoring_status = "Within limit";
        } elseif ($request->statusKci  == 1) {
            $monitoring_status = "Out of limit";
        }

        $updateKpiStatus = [
            'monitoring_status' => $monitoring_status
        ];

        Kci::where('id', $id)->update($updateKpiStatus);

        $dataIssue = [
            "id_kci" => $id,
            "title" => $request->title,
            "id_org" => $getKci->id_org,
            "followup_status" => 1,
            "type" => 1,
            "information_source" => 8,
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

    public function deleteKci(Request $request, $id)
    {
        $rq = $request->all();

        $check_kci = Kci::where('id', $id)->first();

        if (!isset($check_kci->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "KRI is not Found!",
            ]);
        } else {
            try {
                if (isset($rq['reasonKci'])) {
                    $deleteDataKci = Kci::where('id', $id)->delete();
                    return response()->json([
                        "success" => true,
                        "data" => $deleteDataKci,
                        "message" => "Delete Kci Success!",
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

    public function exportData()
    {

        $query = Kci::query();
        $query->leftJoin('organization', 'organization.id', '=', 'kci.id_org');
        $query->leftJoin('controls_activity', 'controls_activity.id', '=', 'kci.id_control_activity');
        $query->leftJoin('controls', 'controls.id', '=', 'controls_activity.id_control');
        $query->leftJoin('programs', 'programs.id', '=', 'controls.id_program');
        $query->select(
            'kci.id',
            'kci.monitoring_status',
            'kci.title as kci_name',
            'programs.id as id_program',
            'programs.program_title',
            'organization.name_org',
        );

        $kci = $query
            ->orderBy("id", "ASC")
            ->get();

        return Excel::download(new KciExprt($kci), 'Kci-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
