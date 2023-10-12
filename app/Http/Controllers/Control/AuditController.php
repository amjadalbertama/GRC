<?php

namespace App\Http\Controllers\Control;

use App\Exports\Controls\Audit as ControlsAudit;
use App\Exports\Controls\AuditActivity as ControlsAuditActivity;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\{
    Log,
    User,
};
use App\Models\Control\{
    Audit,
    AuditActivity,
    Issue,
    Kci
};
use App\Models\Governances\{
    Programs,
    Organization,
    Periods,
};
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use App\Models\Risk\Kri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AuditController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add audit'),
            'view' => $userdata->hasPermission('view audit'),
            'update' => $userdata->hasPermission('update audit'),
            'delete' => $userdata->hasPermission('delete audit'),
            'approval' => $userdata->hasPermission('approval audit'),
            'reviewer' => $userdata->hasPermission('reviewer audit'),
        ];
        $type = [
            1 => 'General',
            2 => 'Special'
        ];
        $query = Audit::query();
        $query->leftJoin('organization', 'organization.id', '=', 'audit.id_org');
        $query->leftJoin('periods', 'periods.id', '=', 'audit.id_period');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'audit.status');
        if (isset($request->status)) {
            $query->where("audit.status", $request->status);
        }
        if (isset($request->type)) {
            $query->where("audit.type", $type[$request->type]);
        }
        if (isset($request->search_data)) {
            $query->where("organization.name_org", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('audit.deleted_at', null);
        $query->select('audit.id', 'audit.type', 'audit.finding', 'audit.source', 'audit.id_source', 'organization.name_org', 'periods.name_periods', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $Audit = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $audit_trails = Log::where('page', "Audit")->orderBy('created_at', 'asc')->get();
        $data_status_mapping = StatusMapping::select('id','status')->get();

        return view('pages.control.audit.index', ['audit' => $Audit, 'history' => $audit_trails, 'access' => $access, 'pagination' => json_decode(json_encode($Audit->toArray())), 'status_mapping' => $data_status_mapping]);
    }

    public function getAuditDet()
    {
        try {
            $currDate = date('Y-m-d');

            $audit = Audit::leftJoin('organization', 'organization.id', '=', 'audit.id_org')
                ->leftJoin('periods', 'periods.id', '=', 'audit.id_period')
                ->leftJoin('status_mapping', 'status_mapping.id', '=', 'audit.status')
                ->where('audit.deleted_at', null)
                ->select('audit.id', 'audit.type', 'audit.finding', 'organization.name_org', 'periods.name_periods', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
                ->get();

            $org = Organization::where('status', 5)->where('deleted_at', null)->get();
            $period = Periods::where('status', 5)
                ->where('deleted_at', null)
                ->where('start_date', '<=', $currDate)
                ->where('end_date', '>=', $currDate)
                ->get();


            return response()->json([
                "success" => true,
                "data" => $audit,
                "org" => $org,
                "period" => $period,
                "message" => "Data Audit Detail Berhasil Ditampilkan!",
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

    public function getAuditAct(\App\Library\GroupPermissions $userdata, $id, Request $request)
    {
        $currDate = date('Y-m-d');

        $access = [
            'add' => $userdata->hasPermission('add audit'),
            'view' => $userdata->hasPermission('view audit'),
            'update' => $userdata->hasPermission('update audit'),
            'delete' => $userdata->hasPermission('delete audit'),
            'approval' => $userdata->hasPermission('approval audit'),
            'reviewer' => $userdata->hasPermission('reviewer audit'),
        ];

        $AuditActR = AuditActivity::where('audit_activity.deleted_at', null)
            ->where('audit_activity.id_audit', $id)
            ->select('audit_activity.id', 'audit_activity.follow_up_status', 'audit_activity.target_date', 'audit_activity.status')
            ->get();

        $Audit = Audit::leftJoin('organization', 'organization.id', '=', 'audit.id_org')
            ->where('audit.id', $id)
            ->select('audit.id', 'audit.type', 'audit.source', 'audit.id_source', 'organization.name_org', 'audit.target_date')
            ->first();

        $checkSpec = Audit::where('source', 'General')
            ->where('id_source', $id)
            ->select('id')
            ->first();

        $audit_trails = Log::where('page', "Controls")->orderBy('created_at', 'asc')->get();

        foreach ($AuditActR as $data) {

            if ($currDate > $data->target_date && $data->status != 5) {

                $followStat = 3;

                $updateFollowStat = AuditActivity::where('id', $data->id)->update([
                    "follow_up_status" => $followStat
                ]);
            } elseif ($currDate <= $data->target_date && $data->status != 5 && $data->follow_up_status != 4) {
                $followStat = 1;

                $updateFollowStat = AuditActivity::where('id', $data->id)->update([
                    "follow_up_status" => $followStat
                ]);
            }
        }

        $query = AuditActivity::query();
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'audit_activity.status');
        $query->leftJoin('type_statfollowup_issue', 'type_statfollowup_issue.id', '=', 'audit_activity.follow_up_status');
        if (isset($request->search_data)) {
            $query->where("audit_activity.audit_finding", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('audit_activity.deleted_at', null);
        $query->where('audit_activity.id_audit', $id);
        $query->select('audit_activity.id', 'audit_activity.audit_finding', 'audit_activity.id_audit', 'audit_activity.ofi', 'audit_activity.recommendation', 'audit_activity.target_date', 'audit_activity.follow_up_status', 'audit_activity.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text', 'type_statfollowup_issue.name_status as foll_stat', 'type_statfollowup_issue.style_status as foll_style_stat');
        $AuditAct = $query->paginate(20);

        return view('pages.control.audit.activity', ['audit' => $Audit, 'audit_act' => $AuditAct, 'audit_generate' => $checkSpec, 'history' => $audit_trails, 'access' => $access, 'pagination' => json_decode(json_encode($AuditAct->toArray()))]);
    }

    public function getAuditDetId($id)
    {
        $user = Auth::user();

        try {
            $currDate = date('Y-m-d');

            $audit = Audit::leftJoin('organization', 'organization.id', '=', 'audit.id_org')
                ->leftJoin('periods', 'periods.id', '=', 'audit.id_period')
                ->leftJoin('status_mapping', 'status_mapping.id', 'audit.status')
                ->where('audit.deleted_at', null)
                ->where('audit.id', $id)
                ->select('audit.id', 'audit.type', 'audit.reason', 'audit.source', 'audit.id_source', 'audit.target_date', 'organization.id as id_org', 'organization.name_org', 'periods.name_periods', 'periods.id as id_period', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
                ->first();

            $org = Organization::where('status', 5)->where('deleted_at', null)->get();
            $period = Periods::where('status', 5)
                ->where('deleted_at', null)
                ->where('start_date', '<=', $currDate)
                ->where('end_date', '>=', $currDate)
                ->get();

            return response()->json([
                "success" => true,
                "data" => $audit,
                "org" => $org,
                "period" => $period,
                "user" => $user,
                "message" => "Data Audit Detail Berhasil Ditampilkan!",
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

    public function getAuditActDetId(\App\Library\GroupPermissions $userdata, $id)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add audit'),
            'view' => $userdata->hasPermission('view audit'),
            'update' => $userdata->hasPermission('update audit'),
            'delete' => $userdata->hasPermission('delete audit'),
            'approval' => $userdata->hasPermission('approval audit'),
            'reviewer' => $userdata->hasPermission('reviewer audit'),
        ];

        try {
            $audit_act = AuditActivity::where('deleted_at', null)
                ->leftJoin('status_mapping', 'status_mapping.id', 'audit_activity.status')
                ->where('audit_activity.id', $id)
                ->select('audit_activity.id', 'audit_activity.audit_finding', 'audit_activity.ofi', 'audit_activity.recommendation', 'audit_activity.target_date', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
                ->first();
            
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Audit Activity")->where("module_id", $id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            return response()->json([
                "success" => true,
                "data" => $audit_act,
                "review" => $getReview,
                "access" => $access,
                "user" => $user,
                "message" => "Data Finding Audit Detail Berhasil Ditampilkan!",
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

    public function addAudit(Request $request)
    {
        $rq = $request->all();

        try {

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['organization_id'] != null && $rq['period_id'] != null) {

                $dataAudit = [
                    'id_org' => $rq['organization_id'],
                    'id_period' => $rq['period_id'],
                    'target_date' => $rq['target_date'],
                    'type' => 'General',
                    'finding' => 0,
                    'status' => 1
                ];

                $generateAudit = Audit::create($dataAudit);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "CREATED");
                }

                Utility::log("Audit", $user, $generateAudit->id, $email, "CREATED");

                return response()->json([
                    "success" => true,
                    "data" => $generateAudit,
                    "message" => "Data Audit berhasil dibuat!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Organization dan Period Tidak boleh kosong!",
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

    public function addAuditAct(Request $request)
    {
        $rq = $request->all();

        try {

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['id_audit'] != null && $rq['finding_title'] != null && $rq['ofi'] != null && $rq['recommendation'] != null && $rq['target_date'] != null) {

                $dataAudit = [
                    'id_audit' => $rq['id_audit'],
                    'audit_finding' => $rq['finding_title'],
                    'ofi' => $rq['ofi'],
                    'recommendation' => $rq['recommendation'],
                    'target_date' => $rq['target_date'],
                    'status' => 1,
                    'follow_up_status' => 1
                ];

                $generateAudit = AuditActivity::create($dataAudit);

                $getAudit = AuditActivity::where('id_audit', $rq['id_audit'])->get()->toArray();

                $updateAudit = Audit::where('id', $rq['id_audit'])->update([
                    "finding" => sizeof($getAudit)
                ]);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "CREATED");
                }

                Utility::log("Audit", $user, $generateAudit->id, $email, "CREATED");

                return response()->json([
                    "success" => true,
                    "data" => $generateAudit,
                    "message" => "Data Findings berhasil dibuat!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data yang diisikan Tidak boleh kosong!",
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

    public function genSpecAudit(Request $request)
    {
        $rq = $request->all();

        try {
            $getAudit = Audit::where('id', $rq['id_audit'])->first();

            if ($getAudit->type == 'Special') {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Special Audit sudah pernah digenerate pada Audit ini!",
                ]);
            }

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['id_audit'] != null && $rq['reason'] != null) {

                $dataAudit = [
                    'type' => 'Special',
                    'id_org' => $getAudit->id_org,
                    'id_period' => $getAudit->id_period,
                    'finding' => 0,
                    'source' => 'General',
                    'id_source' => $rq['id_audit'],
                    'target_date' => $getAudit->target_date,
                    'reason' => $rq['reason'],
                    'status' => 1
                ];

                $generateAudit = Audit::create($dataAudit);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "CREATED");
                }

                Utility::log("Audit", $user, $generateAudit->id, $email, "CREATED");

                return response()->json([
                    "success" => true,
                    "data" => $generateAudit,
                    "message" => "Special Audit berhasil digenerate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data yang diisikan Tidak boleh kosong!",
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

    public function editAudit(Request $request)
    {
        $rq = $request->all();

        try {

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['id_audit'] != null && $rq['organization'] != null && $rq['periods'] != null && $rq['target_date'] != null) {

                $dataEditAudit = [
                    'id_org' => $rq['organization'],
                    'id_period' => $rq['periods'],
                    'target_date' => $rq['target_date'],
                    'status' => 3
                ];

                $updateAudit = Audit::where('id', $rq['id_audit'])->update($dataEditAudit);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "UPDATE");
                }

                Utility::log("Audit", $user, $rq['id_audit'], $email, "UPDATE");

                return response()->json([
                    "success" => true,
                    "data" => $updateAudit,
                    "message" => "Data Audit berhasil diupdate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Input Tidak boleh kosong!",
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

    public function editAuditFinding(Request $request)
    {
        $rq = $request->all();

        try {

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['id_audit_activity'] != null && $rq['finding_title'] != null && $rq['ofi'] != null && $rq['recommendation'] != null && $rq['target_date'] != null) {

                $dataEditAuditFinding = [
                    'audit_finding' => $rq['finding_title'],
                    'ofi' => $rq['ofi'],
                    'recommendation' => $rq['recommendation'],
                    'target_date' => $rq['target_date'],
                    'follow_up_status' => $rq['fol_status'],
                    'status' => 3
                ];

                $updateAuditFinding = AuditActivity::where('id', $rq['id_audit_activity'])->update($dataEditAuditFinding);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "UPDATE");
                }

                Utility::log("Audit", $user, $rq['id_audit_activity'], $email, "UPDATE");

                return response()->json([
                    "success" => true,
                    "data" => $updateAuditFinding,
                    "message" => "Data Audit Findings berhasil diupdate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Input Tidak boleh kosong!",
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

    public function approveAudit(Request $request)
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

        $checkAudit = Audit::where("id", $rq["id_audit"])
            ->first();

        if (!isset($checkAudit->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Audit tidak ditemukan!",
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
                    Utility::notif("Audit", $request, $data, "APPROVED");
                }

                Utility::log("Audit", $user, $rq["id_audit"], $email, "APPROVED");

                if ($rq['notes'] != "") {
                    $createReview = Utility::reviewLog("Audit", $rq["id_audit"], $user, $rq['notes'], "Approved");
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
                    Utility::notif("Audit", $request, $data, "REJECTED");
                }
                
                Utility::log("Audit", $user, $rq["id_audit"], $email, "REJECTED");

                if ($rq['notes'] != "") {
                    $createReview = Utility::reviewLog("Audit", $rq["id_audit"], $user, $rq['notes'], "Recheck");
                }
            }
            
            Audit::where('id', $rq["id_audit"])->update($update);

            DB::commit();

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Data Audit berhasil di Approve!",
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

    public function approveAuditAct(Request $request)
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
        
        $checkAuditAct = AuditActivity::where("id", $rq["id_audit_activity"])
            ->first();

        if (!isset($checkAuditAct->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Audit Activity tidak ditemukan!",
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
                    Utility::notif("Audit", $request, $data, "APPROVED");
                }

                Utility::log("Audit", $user, $rq["id_audit_activity"], $email, "APPROVED");

                if ($rq['notes'] != "") {
                    $createReview = Utility::reviewLog("Audit Activity", $rq["id_audit_activity"], $user, $rq['notes'], "Approved");
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
                    Utility::notif("Audit", $request, $data, "REJECTED");
                }
                
                Utility::log("Audit", $user, $rq["id_audit_activity"], $email, "REJECTED");

                if ($rq['notes'] != "") {
                    $createReview = Utility::reviewLog("Audit Activity", $rq["id_audit_activity"], $user, $rq['notes'], "Recheck");
                }
            }
            
            AuditActivity::where('id', $rq["id_audit_activity"])->update($update);

            DB::commit();

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Data Audit berhasil di Approve!",
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

    public function deleteAudit(Request $request)
    {
        $rq = $request->all();

        try {

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['id_audit'] != null) {

                $deleteStatAudit = Audit::where('id', $rq['id_audit'])->update([
                    'status' => 6
                ]);
                $deleteAudit = Audit::find($rq['id_audit'])->delete();

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "DELETE");
                }

                Utility::log("Audit", $user, $rq['id_audit'], $email, "DELETE");

                return response()->json([
                    "success" => true,
                    "data" => $deleteAudit,
                    "message" => "Data Audit berhasil dihapus!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Input Tidak boleh kosong!",
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

    public function deleteAuditAct(Request $request)
    {
        $rq = $request->all();

        try {

            DB::beginTransaction();

            $user = Auth::user();

            if ($rq['id_audit_activity'] != null) {

                $deleteStatAuditAct = AuditActivity::where('id', $rq['id_audit_activity'])->update([
                    'status' => 6
                ]);
                $deleteAuditAct = AuditActivity::find($rq['id_audit_activity'])->delete();

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', 0)
                    ->where('roles.id', 4)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Audit", $request, $data, "DELETE");
                }

                Utility::log("Audit", $user, $rq['id_audit_activity'], $email, "DELETE");

                return response()->json([
                    "success" => true,
                    "data" => $deleteAuditAct,
                    "message" => "Data Audit Finding berhasil dihapus!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Input Tidak boleh kosong!",
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

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        
        $query = Audit::query();
        $query->leftJoin('organization', 'organization.id', '=', 'audit.id_org');
        $query->leftJoin('periods', 'periods.id', '=', 'audit.id_period');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'audit.status');
        if (isset($request->status)) {
            $query->where("audit.status", $request->status);
        }
        if (isset($request->search_data)) {
            $query->where("organization.name_org", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('audit.deleted_at', null);
        $query->select('audit.id', 'audit.type', 'audit.finding', 'audit.source', 'audit.id_source', 'organization.name_org', 'periods.name_periods', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $Audit = $query->get();

        return Excel::download(new ControlsAudit($Audit), 'audit-'.date("Y-m-d_H:i:s").'.xlsx');
    }

    public function exportDataAct(Request $request, $id)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $query = AuditActivity::query();
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'audit_activity.status');
        $query->leftJoin('type_statfollowup_issue', 'type_statfollowup_issue.id', '=', 'audit_activity.follow_up_status');
        if (isset($request->search_data)) {
            $query->where("audit_activity.audit_finding", "LIKE", "%" . $request->search_data . "%");
        }
        $query->where('audit_activity.deleted_at', null);
        $query->where('audit_activity.id_audit', $id);
        $query->select('audit_activity.id', 'audit_activity.audit_finding', 'audit_activity.id_audit', 'audit_activity.ofi', 'audit_activity.recommendation', 'audit_activity.target_date', 'audit_activity.follow_up_status', 'audit_activity.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text', 'type_statfollowup_issue.name_status as foll_stat', 'type_statfollowup_issue.style_status as foll_style_stat');
        $AuditAct = $query->paginate(20);

        return Excel::download(new ControlsAuditActivity($AuditAct), 'aucit_activity-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
