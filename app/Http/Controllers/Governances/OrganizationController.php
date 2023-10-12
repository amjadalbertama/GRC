<?php

namespace App\Http\Controllers\Governances;

use App\Exports\Governances\Organization as GovernancesOrganization;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Governances\Organization;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Log,
    User,
};
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use Maatwebsite\Excel\Facades\Excel;

class OrganizationController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();

        $access = [
            'add' => $userdata->hasPermission('add organization'),
            'view' => $userdata->hasPermission('view organization'),
            'update' => $userdata->hasPermission('update organization'),
            'delete' => $userdata->hasPermission('delete organization'),
            'approval' => $userdata->hasPermission('approval organization'),
            'reviewer' => $userdata->hasPermission('reviewer organization'),
        ];

        $query = Organization::query();
        $query->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'organization.status');
        $query->select('organization.id', 'organization.name_org', 'organization.lead_role', 'organization.upper_org_id', 'users.name', 'organization.description', 'organization.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');

        if (isset($request->status)) {
            $query->where("organization.status", $request->status);
        }

        if (isset($rq["search_name"]) && $rq["search_name"] != "" || isset($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(organization.name_org LIKE '%" . $rq["search_name"] . "%')");
        }

        if (isset($rq["created_date"])) {
            if ($rq["created_date"] == 0) {
                $order = "DESC";
            } else {
                $order = "ASC";
            }

            $query->orderBy("organization.created_at", $order);
        }

        $organiz = $query
            ->orderBy("id", "DESC")
            ->paginate(10);
            
        $organiz_data = [];
        
        foreach ($organiz as $org_data) {
            $org = Organization::where('deleted_at', null)->where('id', $org_data->upper_org_id)->first();
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Organization")->where("module_id", $org_data->id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            if (isset($org->name_org)) {
                $upper_name = $org->name_org;
            } else {
                $upper_name = "";
            }

            $organiz_data[] = [
                'id' => $org_data->id,
                'name_org' => $org_data->name_org,
                'upper_org_id' => $org_data->upper_org_id,
                'upper_name' => $upper_name,
                'lead_role' => $org_data->lead_role,
                'name' => $org_data->name,
                'description' => $org_data->description,
                'notes' => $org_data->notes,
                'status' => $org_data->status,
                'status_style' => $org_data->status_style,
                'status_text' => $org_data->status_text,
                'review_log' => $getReview,
                'review_log_count' => sizeof($getReview)
            ];
        }
        $toJsonStr = json_encode($organiz_data);
        $organizations = json_decode($toJsonStr);

        $audit_trails = Log::where('page', "Organization")->orderBy('created_at', 'asc')->get();
        $data_status_mapping = StatusMapping::select('id','status')->get();

        $lead_role = DB::table('users')->where('role_id', 3)->where('org_id', 1)->get();
        return view('pages.governance.organization.index', ['organization' => $organizations, 'pagination' => json_decode(json_encode($organiz->toArray())), 'lead_role' => $lead_role, 'access' => $access, 'audit_trails' => $audit_trails, 'status_mapping' => $data_status_mapping]);
    }

    public function search(Request $request)
    {

        $search = $request->search;
        $tes = DB::table('')
            ->where('no_kontrak', 'like', "%" . $search . "%")
            ->orWhere('nama_debitur', 'LIKE', '%' . $search . '%')

            ->paginate(10);
        return view('', ['' => $tes]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        $organization = Organization::where('name_org', $request->name_org)->first();

        if ($organization !== null) {
            return redirect('organization')->with('addorgfail', 'Data organisasi gagal ditambahkan, Nama Organisasi sudah ada');
        }

        try {

            DB::beginTransaction();

            $insert = [
                'name_org' => $request->name_org,
                'upper_org_id' => $request->upper_org_id,
                'lead_role' => $request->lead_role,
                'description' => $request->description,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $org_id = Organization::insertGetId($insert);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 5)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Organization", $request, $data, "CREATED");
            }

            $user = Auth::user();
            Utility::log("Organization", $user, $org_id, $email, "CREATED");


            return redirect('organization')->with('addorg', 'Data organisasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('organization')->with('addorgfail', 'Data organisasi gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $update = [
                'name_org' => $request->name_org,
                'upper_org_id' => $request->upper_org_id,
                'lead_role' => $request->lead_role,
                'description' => $request->description,
                'status' => 3
            ];

            Organization::where('id', $id)->update($update);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 5)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Organization", $request, $data, "RESUBMITTED");
            }

            $user = Auth::user();

            Utility::log("Organization", $user, $id, $email, "RESUBMITTED");


            return redirect('organization')->with('update', 'Data organisasi berhasil diubah.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('organization')->with('update', 'Data organisasi gagal diubah.');
        }
    }

    public function delete($id)
    {
        DB::table('organization')->where('id', $id)->delete();
        return redirect('organization')->with('delete', 'Data organization berhasil dihapus.');
    }

    public function approval(Request $request, $id)
    {
        try {
            if(!isset($request->revnotes) || $request->revnotes == ''){
                return redirect('organization')->with('approvefail', 'Kolom Review Notes tidak boleh kosong.');
            }

            DB::beginTransaction();

            if ($request->input('action') == 'approve') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 5,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id', 1)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Organization", $request, $data, "APPROVED");
                }

                $user = Auth::user();

                Utility::log("Organization", $user, $id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Organization", $id, $user, $request->revnotes, "Approved");
                }
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id', 5)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Organization", $request, $data, "REJECTED");
                }

                $user = Auth::user();

                Utility::log("Organization", $user, $id, $email, "REJECTED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Organization", $id, $user, $request->revnotes, "Recheck");
                }
            }

            Organization::where('id', $id)->update($update);

            DB::commit();

            return redirect('organization')->with('approve', 'Data organisasi berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('organization')->with('approvefail', 'Data organisasi gagal diupdate.');
        }
    }

    public function getListOrg()
    {
        $getOrg = Organization::get();

        if (sizeof($getOrg) != 0) {
            return response()->json([
                "success" => true,
                "data" => $getOrg,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getOrg,
                "message" => "Organization is empty, please contact your Admin to add the Organization!",
            ]);
        }
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $query = Organization::query();
        $query->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'organization.status');
        $query->select('organization.id', 'organization.name_org', 'organization.lead_role', 'organization.upper_org_id', 'users.name', 'organization.description', 'organization.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');

        if (isset($request->status)) {
            $query->where("organization.status", $request->status);
        }

        if (isset($rq["search_name"]) && $rq["search_name"] != "" || isset($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(organization.name_org LIKE '%" . $rq["search_name"] . "%')");
        }

        if (isset($rq["created_date"])) {
            if ($rq["created_date"] == 0) {
                $order = "DESC";
            } else {
                $order = "ASC";
            }

            $query->orderBy("organization.created_at", $order);
        }

        $organiz = $query->get();
            
        $organiz_data = [];
        
        foreach ($organiz as $org_data) {
            $org = Organization::where('deleted_at', null)->where('id', $org_data->upper_org_id)->first();

            if (isset($org->name_org)) {
                $upper_name = $org->name_org;
            } else {
                $upper_name = "";
            }

            $organiz_data[] = [
                'id' => $org_data->id,
                'name_org' => $org_data->name_org,
                'upper_org_id' => $org_data->upper_org_id,
                'upper_name' => $upper_name,
                'lead_role' => $org_data->lead_role,
                'name' => $org_data->name,
                'status' => $org_data->status_text
            ];
        }
        $toJsonStr = json_encode($organiz_data);
        $organizations = json_decode($toJsonStr);

        return Excel::download(new GovernancesOrganization($organizations), 'organization-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
