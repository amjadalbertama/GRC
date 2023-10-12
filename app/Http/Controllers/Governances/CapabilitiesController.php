<?php

namespace App\Http\Controllers\Governances;

use App\Exports\Governances\Capabilities as GovernancesCapabilities;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\Governances\{
    Capabilities,
    Organization
};
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CapabilitiesController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add capabilities'),
            'view' => $userdata->hasPermission('view capabilities'),
            'update' => $userdata->hasPermission('update capabilities'),
            'delete' => $userdata->hasPermission('delete capabilities'),
            'approval' => $userdata->hasPermission('approval capabilities'),
            'reviewer' => $userdata->hasPermission('reviewer capabilities'),
        ];

        $query = Capabilities::query();
        $query->leftJoin('organization', 'organization.id', '=', 'capabilities.org_id');
        $query->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'capabilities.status');

        if ($user->org_id != 0) {
            $query->orderBy('id', 'DESC')->where('organization.id', $user->org_id);
        }

        if (isset($request->status)) {
            $query->where("capabilities.status", $request->status);
        }

        if (isset($rq["search_name"]) && $rq["search_name"] != "" || isset($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(capabilities.name LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'capabilities.id',
            'capabilities.name',
            'organization.name_org',
            'capabilities.description',
            'capabilities.business_planning',
            'capabilities.business_operation',
            'capabilities.business_evaluation',
            'capabilities.business_improvement',
            'capabilities.business_effectiveness',
            'capabilities.personel_number',
            'capabilities.personel_level',
            'capabilities.personel_productivity',
            'capabilities.tooltech_tools_installed',
            'capabilities.tooltech_tech_installed',
            'capabilities.tooltech_capacity',
            'capabilities.resource_financial',
            'capabilities.resource_non_financial',
            'capabilities.resource_adequacy_allocated',
            'users.name as lead_name',
            'capabilities.notes',
            'status_mapping.status',
            'status_mapping.style as status_style',
            'status_mapping.text as status_text'
        );

        $capability = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);
        
        $capability_data = [];

        foreach ($capability as $cap_data) {
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Capabilities")->where("module_id", $cap_data->id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            $capability_data[] = [
                'id' => $cap_data->id,
                'name' => $cap_data->name,
                'name_org' => $cap_data->name_org,
                'description' => $cap_data->description,
                'business_planning' => $cap_data->business_planning,
                'business_operation' => $cap_data->business_operation,
                'business_evaluation' => $cap_data->business_evaluation,
                'business_improvement' => $cap_data->business_improvement,
                'business_effectiveness' => $cap_data->business_effectiveness,
                'personel_number' => $cap_data->personel_number,
                'personel_level' => $cap_data->personel_level,
                'personel_productivity' => $cap_data->personel_productivity,
                'tooltech_tools_installed' => $cap_data->tooltech_tools_installed,
                'tooltech_tech_installed' => $cap_data->tooltech_tech_installed,
                'tooltech_capacity' => $cap_data->tooltech_capacity,
                'resource_financial' => $cap_data->resource_financial,
                'resource_non_financial' => $cap_data->resource_non_financial,
                'resource_adequacy_allocated' => $cap_data->resource_adequacy_allocated,
                'lead_name' => $cap_data->lead_name,
                'notes' => $cap_data->notes,
                'status' => $cap_data->status,
                'status_style' => $cap_data->status_style,
                'status_text' => $cap_data->status_text,
                'review_log' => $getReview,
                'review_log_count' => sizeof($getReview)
            ];
        }
        $toJsonStr = json_encode($capability_data);
        $capabilities = json_decode($toJsonStr);
        $data_status_mapping = StatusMapping::select('id','status')->get();

        $audit_trails = Log::where('page', "Capabilities")->orderBy('created_at', 'asc')->get();
        return view('pages.governance.capabilities.index', ['capabilities' => $capabilities, 'pagination' => json_decode(json_encode($capability->toArray())), 'access' => $access, 'audit_trails' => $audit_trails, 'status_mapping' => $data_status_mapping]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        $capabilities = Capabilities::where('name', $request->name)->first();

        if (isset($capabilities->name)) {
            return redirect('capabilities')->with('addcapabilitiesfail', 'Nama Capabilities telah ada.');
        }

        try {

            DB::beginTransaction();

            $organiz = Organization::leftJoin('users', 'users.id', '=', 'organization.lead_role')
                ->where('organization.id', $user->org_id)
                ->select('organization.id', 'organization.name_org', 'organization.upper_org_id', 'users.name', 'organization.description')
                ->first();

            $insert = [
                'name' => $request->name,
                'org_id' => $user->org_id,
                'name_org' => $organiz->name_org,
                'lead_role' => $organiz->name,
                'description' => $request->outcome,
                'business_planning' => $request->business_planning,
                'business_operation' => $request->business_operation,
                'business_evaluation' => $request->business_evaluation,
                'business_improvement' => $request->business_improvement,
                'business_effectiveness' => $request->business_effectiveness,
                'personel_number' => $request->personel_number,
                'personel_level' => $request->personel_level,
                'personel_productivity' => $request->personel_productivity,
                'tooltech_tools_installed' => $request->tooltech_tools_installed,
                'tooltech_tech_installed' => $request->tooltech_tech_installed,
                'tooltech_capacity' => $request->tooltech_capacity,
                'resource_financial' => $request->resource_financial,
                'resource_non_financial' => $request->resource_non_financial,
                'resource_adequacy_allocated' => $request->resource_adequacy_allocated,
                'status' => 1,
            ];

            $cap_id = Capabilities::create($insert);

            DB::commit();

            if (isset($cap_id->id)) {
                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 3)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Capabilities", $request, $data, "CREATED");
                }

                Utility::log("Capabilities", $user, $cap_id, $email, "CREATED");

                return redirect('capabilities')->with('addcapabilities', 'Data Capabilities berhasil ditambahkan.');
            } else {
                return redirect('capabilities')->with('addcapabilitiesfail', 'Data Capabilities gagal ditambahkan.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'e' => [
                    $e->getFile(),
                    $e->getLine(),
                    $e->getMessage()
                ]
            ]);
        }
    }

    public function delete($id)
    {
        Capabilities::where('id', $id)->delete();
        return redirect('capabilities')->with('delete', 'Data Capabilities berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        try {

            $organiz = Organization::leftJoin('users', 'users.id', '=', 'organization.lead_role')
                ->where('organization.id', $user->org_id)
                ->select('organization.id', 'organization.name_org', 'organization.upper_org_id', 'users.name', 'organization.description')
                ->first();

            DB::beginTransaction();

            $update = [
                'name' => $request->name,
                'org_id' => $organiz->id,
                'lead_role' => $organiz->name,
                'description' => $request->description,
                'business_planning' => $request->business_planning,
                'business_operation' => $request->business_operation,
                'business_evaluation' => $request->business_evaluation,
                'business_improvement' => $request->business_improvement,
                'business_effectiveness' => $request->business_effectiveness,
                'personel_number' => $request->personel_number,
                'personel_level' => $request->personel_level,
                'personel_productivity' => $request->personel_productivity,
                'tooltech_tools_installed' => $request->tooltech_tools_installed,
                'tooltech_tech_installed' => $request->tooltech_tech_installed,
                'tooltech_capacity' => $request->tooltech_capacity,
                'resource_financial' => $request->resource_financial,
                'resource_non_financial' => $request->resource_non_financial,
                'resource_adequacy_allocated' => $request->resource_adequacy_allocated,
                'status' => 3,
            ];

            Capabilities::where('id', $id)->update($update);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Capabilities", $request, $data, "RESUBMITTED");
            }

            Utility::log("Capabilities", $user, $id, $email, "RESUBMITTED");

            return redirect('capabilities')->with('update', 'Data Capabilities berhasil diperbarui.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect('capabilities')->with('update', 'Data Capabilities gagal diperbarui.');
        }
    }

    public function approval(Request $request, $id)
    {
        $user = Auth::user();
        $capabilities = Capabilities::where('id', $id)->first();

        if(!isset($request->revnotes) || $request->revnotes == ''){
            return redirect('capabilities')->with('approvecapabilitiesfail', 'Kolom Review Notes tidak boleh kosong.');
        }

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
                        ->where('users.org_id', $capabilities->org_id)
                        ->where('roles.id', 2)
                        ->get();
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];

                foreach ($email as $data) {
                    Utility::notif("Capabilities", $request, $data, "APPROVED");
                }

                Utility::log("Capabilities", $user, $id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Capabilities", $id, $user, $request->revnotes, "Approved");
                }

            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $capabilities->org_id)
                    ->where('roles.id', 2)
                    ->get();
                
                foreach ($email as $data) {
                    Utility::notif("Capabilities", $request, $data, "REJECTED");
                }
                
                Utility::log("Capabilities", $user, $id, $email, "REJECTED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Capabilities", $id, $user, $request->revnotes, "Recheck");
                }
            }
                
            Capabilities::where('id', $id)->update($update);
            
            DB::commit(); 

            return redirect('capabilities')->with('approvecapabilities', 'Data capabilities selesai direview.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('capabilities')->with('approvecapabilitiesfail', 'Data capabilities gagal disetujui.');
        }
    }

    public function exportData(Request $request)
    {
        
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        
        $user = Auth::user();

        $query = Capabilities::query();
        $query->leftJoin('organization', 'organization.id', '=', 'capabilities.org_id');
        $query->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'capabilities.status');

        if ($user->org_id != 0) {
            $query->orderBy('id', 'DESC')->where('organization.id', $user->org_id);
        }

        if (isset($request->status)) {
            $query->where("capabilities.status", $request->status);
        }

        if (isset($rq["search_name"]) && $rq["search_name"] != "" || isset($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(capabilities.name LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'capabilities.id',
            'capabilities.name',
            'organization.name_org',
            'capabilities.description',
            'status_mapping.style as status',
        );

        $capability = $query->get();
        
        $capability_data = [];

        foreach ($capability as $cap_data) {

            $capability_data[] = [
                'id' => $cap_data->id,
                'name' => $cap_data->name,
                'name_org' => $cap_data->name_org,
                'description' => $cap_data->description,
                'status' => $cap_data->status
            ];
        }
        $toJsonStr = json_encode($capability_data);
        $capabilities = json_decode($toJsonStr);

        return Excel::download(new GovernancesCapabilities($capabilities), 'capabilities-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
