<?php

namespace App\Http\Controllers\Control;

use App\Exports\Controls\Controls as ControlsControls;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\{
    Log,
    Objective,
    User,
};
use App\Models\Control\{
    Controls,
    ControlsActivity,
    Issue,
    Kci
};
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use App\Models\Governances\Programs;
use App\Models\Governances\Strategies;
use App\Models\Risk\Kri;
use App\Models\Risks\RiskRegisters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ControlsController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add controls'),
            'view' => $userdata->hasPermission('view controls'),
            'update' => $userdata->hasPermission('update controls'),
            'delete' => $userdata->hasPermission('delete controls'),
            'approval' => $userdata->hasPermission('approval controls'),
            'reviewer' => $userdata->hasPermission('reviewer controls'),
        ];

        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        $query = Controls::query();
        $query->leftJoin('programs', 'programs.id', '=', 'controls.id_program');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'controls.status');
        if (isset($request->status)) {
            $query->where("controls.status", $request->status);
        }
        if (isset($request->search_data)) {
            $query->where("controls.title", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('controls.deleted_at', null);
        $query->select('controls.id', 'controls.title', 'programs.id as id_program', 'programs.id_type', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $Control = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);

        if ($Control->isNotEmpty()) {
            foreach ($Control as $data) {
                for ($i = 1; $i <= sizeof($listType); $i++) {
                    if ($i == $data->id_type) {
                        $progtype = $listType[$i];
                    }
                }
                $control_data[] = [
                    "id" => $data->id,
                    "title" => $data->title,
                    "id_program" => $data->id_program,
                    "program_type" => $progtype,
                    "status" => $data->status,
                    "status_style" => $data->status_style,
                    "status_text" => $data->status_text
                ];
            }
        } else {
            $control_data = [];
        }

        $audit_trails = Log::where('page', "Controls")->orderBy('created_at', 'asc')->get();
        $data_status_mapping = StatusMapping::select('id','status')->get();

        return view('pages.control.control.index', ['controls' => $control_data, 'history' => $audit_trails, 'access' => $access, 'pagination' => json_decode(json_encode($Control->toArray())), 'status_mapping' => $data_status_mapping]);
    }

    public function getControlDet($id)
    {
        try {
            $Controls = json_decode(json_encode(Controls::leftJoin('status_mapping', 'status_mapping.id', '=', 'controls.status')
                ->where('controls.id', $id)
                ->select('controls.id', 'controls.title', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
                ->first()), true);

            return response()->json([
                "success" => true,
                "data" => $Controls,
                "message" => "Data Controls Detail Berhasil Ditampilkan!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function getControlAct(\App\Library\GroupPermissions $userdata, $id, Request $request)
    {

        $access = [
            'add' => $userdata->hasPermission('add controls'),
            'view' => $userdata->hasPermission('view controls'),
            'update' => $userdata->hasPermission('update controls'),
            'delete' => $userdata->hasPermission('delete controls'),
            'approval' => $userdata->hasPermission('approval controls'),
            'reviewer' => $userdata->hasPermission('reviewer controls'),
        ];

        $query = ControlsActivity::query();
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'controls_activity.status');
        $query->where('controls_activity.deleted_at', null);
        if (isset($request->search_data)) {
            $query->where("controls_activity.activity_control", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('controls_activity.id_control', $id);
        $query->select('controls_activity.id', 'controls_activity.activity_control', 'controls_activity.activity_type', 'controls_activity.activity_effectiveness', 'controls_activity.id_issue', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $ControlAct = $query->paginate(20);

        $Controls = Controls::where('id', $id)
            ->first();

        $audit_trails = Log::where('page', "Controls")->orderBy('created_at', 'asc')->get();

        return view('pages.control.control.activity', ['controls' => $Controls, 'controls_act' => $ControlAct, 'history' => $audit_trails, 'access' => $access, 'pagination' => json_decode(json_encode($ControlAct->toArray()))]);
    }

    public function getControlActDet(\App\Library\GroupPermissions $userdata, $id)
    {

        $access = [
            'add' => $userdata->hasPermission('add controls'),
            'view' => $userdata->hasPermission('view controls'),
            'update' => $userdata->hasPermission('update controls'),
            'delete' => $userdata->hasPermission('delete controls'),
            'approval' => $userdata->hasPermission('approval controls'),
            'reviewer' => $userdata->hasPermission('reviewer controls'),
        ];
        $user = Auth::user();

        try {

            $Control = json_decode(json_encode(ControlsActivity::leftJoin('status_mapping', 'status_mapping.id', '=', 'controls_activity.status')
                ->leftJoin('kri', 'kri.id', '=', 'controls_activity.id_kri')
                ->leftJoin('issue', 'issue.id_control_activity', '=', 'controls_activity.id_control_issue')
                ->leftJoin('kci', 'kci.id', '=', 'controls_activity.id_kci')
                ->where('controls_activity.deleted_at', null)
                ->where('controls_activity.id', $id)
                ->select('controls_activity.*', 'kci.title as kci_title', 'issue.title as issue_title', 'kri.kri', 'kri.kri_lower', 'kri.kri_upper', 'status_mapping.status as status_curr', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
                ->first()), true);

            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Control Activity")->where("module_id", $id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            return response()->json([
                "success" => true,
                "data" => $Control,
                "access" => $access,
                "user" => $user,
                "review" => $getReview,
                "message" => "Data Controls Activity Berhasil Ditampilkan!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function genControl(Request $request)
    {
        $rq = $request->all();

        $checkControl = Controls::where("id_program", $rq["id_program"])->first();

        if (isset($checkControl->id_program)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Controls dengan ID Program ini sudah ada!",
            ]);
        }

        try {

            DB::beginTransaction();

            $getPrograms = Programs::leftJoin('kri', 'kri.id_risk_register', '=', 'programs.id_risk_register')
                ->where("programs.id", $rq["id_program"])
                ->select('programs.program_title', 'programs.id as id_program', 'programs.controls', 'kri.id as id_kri')
                ->first();
            $user = Auth::user();

            if (isset($getPrograms->controls)) {
                $dataCont = [
                    'title' => $getPrograms->program_title,
                    'id_program' => $getPrograms->id_program,
                    'status' => 1,
                ];

                $generateCont = Controls::create($dataCont);

                $dataContAct = [
                    "activity_control" => "Supervisi pelaksanaan " . $getPrograms->controls,
                    "id_control" => $generateCont->id,
                    "id_kri" => $getPrograms->id_kri,
                    "activity_effectiveness" => "Effective",
                    "activity_status" => "Within Threshold",
                    "activity_type" => "Detective",
                    "status" => 1
                ];

                ControlsActivity::insert($dataContAct);

                DB::commit();

                // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                //     ->where('users.org_id', 0)
                //     ->where('roles.id', 4)
                //     ->get();

                // foreach ($email as $data) {
                //     Utility::notif("Controls", $request, $data, "CREATED");
                // }

                // Utility::log("Controls", $user, $generateCont->id, $email, "CREATED");

                return response()->json([
                    "success" => true,
                    "data" => $generateCont,
                    "message" => "Data Controls berhasil digenerate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Controls belum disave di Programs!",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function editControlAct(Request $request)
    {
        $user = Auth::user();
        $rq = $request->all();

        $check_control = ControlsActivity::where('id', $rq['id'])->first();

        if (!isset($check_control->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Controls Activity Tidak Ditemukan!",
            ]);
        }

        try {

            DB::beginTransaction();

            if ($rq['activity_type'] == 'Detective') {

                $update_data = [
                    "activity_effectiveness" => $rq['effectiveness'],
                    "activity_indicator" => str_replace("%", "", $rq['activity_indicator']),
                    "status" => 3
                ];
            } elseif ($rq['activity_type'] == 'Preventive') {
                $update_data = [
                    "activity_action" => $rq['activity_action'],
                    "activity_result" => $rq['activity_result'],
                    "activity_issue_root_cause" => $rq['issue_root_cause'],
                    "activity_kci" => $rq['kci_title'],
                    "threshold_lower" => str_replace("%", "", $rq['thresholdlow']),
                    "threshold_upper" => str_replace("%", "", $rq['thresholdup']),
                    "activity_effectiveness" => $rq['effectiveness'],
                    "status" => 3
                ];
            } else {
                $update_data = [
                    "activity_action" => $rq['activity_action'],
                    "activity_result" => $rq['activity_result'],
                    "activity_effectiveness" => $rq['effectiveness'],
                    "activity_status" => $rq['activity_status'],
                    "status" => 3
                ];
            }

            $update = ControlsActivity::where('id', $rq['id'])->update($update_data);

            DB::commit();

            // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
            //     ->where('users.org_id', $user->org_id)
            //     ->where('roles.id', 3)
            //     ->get();

            // foreach ($email as $data) {
            //     Utility::notif("Controls", $request, $data, "UPDATED");
            // }

            // Utility::log("Controls", $user, $rq['id'], $email, "UPDATED");

            return response()->json([
                "success" => true,
                "data" => $update,
                "message" => "Berhasil update Control Activity!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function genIssueControl(Request $request)
    {
        $rq = $request->all();

        $checkControl = Issue::where("id_control_activity", $rq["id_control_activity"])->first();

        if (isset($checkControl->id_control_act)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Issue dengan ID Control ini sudah ada!",
            ]);
        }
        if (empty($rq['issue_notes'])) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Issue Notes tidak boleh kosong!",
            ]);
        }

        try {

            DB::beginTransaction();

            $getControlAct = ControlsActivity::leftJoin('kri', 'kri.id', '=', 'controls_activity.id_kri')
                ->where('controls_activity.deleted_at', null)
                ->where('controls_activity.id', $rq["id_control_activity"])
                ->select('controls_activity.*', 'kri.kri', 'kri.kri_lower', 'kri.kri_upper')
                ->first();

            $user = Auth::user();

            if (isset($getControlAct->id)) {

                if ($getControlAct->activity_type == 'Detective') {
                    $info_source = 1;
                } elseif ($getControlAct->activity_type == 'Preventive') {
                    $info_source = 2;
                } elseif ($getControlAct->activity_type == 'Responsive') {
                    $info_source = 3;
                }
                $dataIssue = [
                    'title' => $rq['issue_notes'],
                    'id_org' => $user->org_id,
                    'followup_status' => 1,
                    'id_control_activity' => $getControlAct->id,
                    'information_source' => $info_source,
                    'type' => 1,
                ];

                $generateIssue = Issue::create($dataIssue);

                if ($getControlAct->activity_type == 'Detective') {
                    $dataContAct = [
                        "activity_control" => "Prevention " . $getControlAct->activity_control,
                        "id_control" => $getControlAct->id_control,
                        "id_control_issue" => $rq["id_control_activity"],
                        "activity_effectiveness" => "Effective",
                        "activity_status" => "Within Threshold",
                        "activity_type" => "Preventive",
                        "status" => 1
                    ];


                    $generateCont = ControlsActivity::create($dataContAct);

                    $updateContAct = [
                        "id_issue" => $generateIssue->id,
                    ];

                    $updateCont = ControlsActivity::where('id', $rq["id_control_activity"])->update($updateContAct);
                } else if ($getControlAct->activity_type == 'Preventive') {
                    $actControl = str_replace("Prevention", "Response", $getControlAct->activity_control);

                    $dataContAct = [
                        "activity_control" => $actControl,
                        "id_control" => $getControlAct->id_control,
                        "id_control_issue" => $rq["id_control_activity"],
                        "activity_effectiveness" => "Effective",
                        "activity_status" => "Within Threshold",
                        "activity_type" => "Responsive",
                        "status" => 1
                    ];

                    $generateCont = ControlsActivity::create($dataContAct);

                    $updateContAct = [
                        "id_issue" => $generateIssue->id,
                    ];

                    $updateCont = ControlsActivity::where('id', $rq["id_control_activity"])->update($updateContAct);
                } else {

                    $updateContAct = [
                        "id_issue" => $generateIssue->id,
                    ];

                    $updateCont = ControlsActivity::where('id', $rq["id_control_activity"])->update($updateContAct);
                }

                DB::commit();

                // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                //     ->where('users.org_id', 0)
                //     ->where('roles.id', 4)
                //     ->get();

                // foreach ($email as $data) {
                //     Utility::notif("Issues", $request, $data, "CREATED");

                //     if($getControlAct->activity_type == 'Responsive'){

                //         Utility::notif("Controls", $request, $data, "UPDATED");

                //     } else{
                //         Utility::notif("Controls", $request, $data, "CREATED");
                //     }
                // }

                // if($getControlAct->activity_type == 'Responsive'){
                //     Utility::log("Issues", $user, $generateIssue->id, $email, "CREATED");

                //     Utility::log("Controls", $user, $getControlAct->id, $email, "UPDATED");

                // } else{
                //     Utility::log("Issues", $user, $generateIssue->id, $email, "CREATED");

                //     Utility::log("Controls", $user, $generateCont->id, $email, "CREATED");
                // }

                return response()->json([
                    "success" => true,
                    "data" => $generateIssue,
                    "message" => "Data Issue & Control berhasil digenerate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Issue & Control belum disave di Programs!",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function genKCI(Request $request)
    {
        $rq = $request->all();

        $checkKCI = Kci::where("id_control_activity", $rq["id_control_activity"])->first();

        if (isset($checkKCI->id_control_activity)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KCI dengan ID Activity Control ini sudah ada!",
            ]);
        }

        try {

            DB::beginTransaction();

            $getControlAct = ControlsActivity::leftJoin('kri', 'kri.id', '=', 'controls_activity.id_kri')
                ->where('controls_activity.deleted_at', null)
                ->where('controls_activity.id', $rq["id_control_activity"])
                ->select('controls_activity.*', 'kri.kri', 'kri.kri_lower', 'kri.kri_upper')
                ->first();

            $getControl = Controls::where('id', $getControlAct->id_control)->first();
            $getProgram = Programs::where('id', $getControl->id_program)->first();
            $getRisk = RiskRegisters::where('id', $getProgram->id_risk_register)->first();
            $getObjective = Objective::where('id', $getRisk->id_objective)->first();
            $user = Auth::user();

            if (isset($getControlAct->activity_kci)) {

                $dataKci = [
                    'title' => $rq['kci_title'],
                    'id_org' => $getObjective->id_organization,
                    'threshold_lower' => str_replace("%", "", $rq['kci_low']),
                    'threshold_upper' => str_replace("%", "", $rq['kci_upper']),
                    'id_control_activity' => $getControlAct->id,
                    'monitoring_status' => "Within limit",
                    'created_at' => date("Y-m-d H:i:s"),
                ];

                $generateKci = Kci::create($dataKci);

                $updateContAct = [
                    'id_kci' => $generateKci->id,
                    'activity_kci' => $rq['kci_title'],
                    'threshold_lower' => str_replace("%", "", $rq['kci_low']),
                    'threshold_upper' => str_replace("%", "", $rq['kci_upper']),
                ];

                $updateCont = ControlsActivity::where('id', $rq["id_control_activity"])->update($updateContAct);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("KCI", $request, $data, "CREATED");
                }

                Utility::log("KCI", $user, $generateKci->id, $email, "CREATED");


                return response()->json([
                    "success" => true,
                    "data" => $generateKci,
                    "message" => "Data KCI berhasil digenerate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data KCI belum disave di Control Activity!",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function approveControl(Request $request)
    {
        $rq = $request->all();
        $user = Auth::user();

        if(!isset($rq['notes']) || $rq['notes'] == ""){
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Review Notes tidak boleh kosong!",
            ]);
        }

        $checkControl = Controls::where("id", $rq["id_control"])
            ->first();

        if (!isset($checkControl->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Controls tidak ditemukan!",
            ]);
        }

        try {

            DB::beginTransaction();

            if ($rq["action"] == 'Approval') {

                if ($user->role_id == 7) {
                    $status = 4;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('roles.id', 6)
                        ->get();
                } elseif ($user->role_id == 5) {
                    $status = 5;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('roles.id', 6)
                        ->get();
                }

                $update = [
                    'notes' => $rq['notes'],
                    'status' => $status,
                ];

                foreach ($email as $data) {
                    Utility::notif("Controls", $request, $data, "APPROVED");
                }

                Utility::log("Controls", $user, $rq["id_control"], $email, "APPROVED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Controls", $rq["id_control"], $user, $rq['notes'], "Approved");
                }
            } else if ($rq['action'] == 'Recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id', 6)
                    ->get();

                    
                foreach ($email as $data) {
                    Utility::notif("Controls", $request, $data, "REJECTED");
                }
                
                Utility::log("Controls", $user, $rq["id_control"], $email, "REJECTED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Controls", $rq["id_control"], $user, $rq['notes'], "Recheck");
                }
            }
            Controls::where('id', $rq["id_control"])->update($update);

            DB::commit();

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Data Controls berhasil di Approve!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function approveControlAct(Request $request)
    {
        $rq = $request->all();
        $user = Auth::user();
        
        if(!isset($rq['notes']) || $rq['notes'] == ""){
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Review Notes tidak boleh kosong!",
            ]);
        }

        $checkControlAct = ControlsActivity::where("id", $rq["id_control_activity"])
            ->first();

        if (!isset($checkControlAct->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Controls Activity tidak ditemukan!",
            ]);
        }

        try {

            DB::beginTransaction();

            if ($rq["action"] == 'Approval') {

                if ($user->role_id == 7) {
                    $status = 4;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('roles.id', 6)
                        ->get();
                } elseif ($user->role_id == 5) {
                    $status = 5;

                    $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                        ->where('roles.id', 6)
                        ->get();
                }

                $update = [
                    'notes' => $rq['notes'],
                    'status' => $status,
                ];

                foreach ($email as $data) {
                    Utility::notif("Controls", $request, $data, "APPROVED");
                }

                Utility::log("Controls", $user, $rq["id_control_activity"], $email, "APPROVED");

                if ($rq['notes'] != "") {
                    $createReview = Utility::reviewLog("Control Activity", $rq["id_control_activity"], $user, $rq['notes'], "Approved");
                }

            } else if ($rq['action'] == 'Recheck') {
                $update = [
                    'notes' => $rq['notes'],
                    'status' => 2,
                ];
                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id', 6)
                    ->get();

                    
                foreach ($email as $data) {
                    Utility::notif("Controls", $request, $data, "REJECTED");
                }
                
                Utility::log("Controls", $user, $rq["id_control_activity"], $email, "REJECTED");

                if ($rq['notes'] != "") {
                    $createReview = Utility::reviewLog("Control Activity", $rq["id_control_activity"], $user, $rq['notes'], "Recheck");
                }
            }

            ControlsActivity::where('id', $rq["id_control_activity"])->update($update);

            DB::commit();

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Data Controls Activity berhasil di Approve!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        
        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        $query = Controls::query();
        $query->leftJoin('programs', 'programs.id', '=', 'controls.id_program');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'controls.status');
        if (isset($request->status)) {
            $query->where("controls.status", $request->status);
        }
        if (isset($request->search_data)) {
            $query->where("controls.title", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('controls.deleted_at', null);
        $query->select('controls.id', 'controls.title', 'programs.id as id_program', 'programs.id_type', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $Control = $query->get();

        if ($Control->isNotEmpty()) {
            foreach ($Control as $data) {
                for ($i = 1; $i <= sizeof($listType); $i++) {
                    if ($i == $data->id_type) {
                        $progtype = $listType[$i];
                    }
                }
                $control_data[] = [
                    "id" => $data->id,
                    "title" => $data->title,
                    "id_program" => $data->id_program,
                    "program_type" => $progtype,
                    "status" => $data->status,
                    "status_style" => $data->status_style,
                    "status_text" => $data->status_text
                ];
            }
        } else {
            $control_data = [];
        }

        return Excel::download(new ControlsControls($control_data), 'control-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
