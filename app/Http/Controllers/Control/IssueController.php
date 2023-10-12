<?php

namespace App\Http\Controllers\Control;

use App\Exports\Controls\IssueExprt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\Facades\Utility;
use App\Models\{
    Log,
    User,
};
use App\Models\Control\{
    Issue,
    Kci
};
use App\Models\Control\TypeIssue\{
    IssueInformationSource,
    TypeStatfollowupIssue,
    TypeCategoryIssue,
    TypeIssues,
};
use App\Models\Governances\Organization;
use Maatwebsite\Excel\Facades\Excel;

class IssueController extends Controller
{

    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();
        $user = Auth::user();
        $access = [
            'add' => $userdata->hasPermission('add issues'),
            'view' => $userdata->hasPermission('view issues'),
            'update' => $userdata->hasPermission('update issues'),
            'delete' => $userdata->hasPermission('delete issues'),
            'approval' => $userdata->hasPermission('approval issues'),
            'reviewer' => $userdata->hasPermission('reviewer issues'),
        ];

        $query = Issue::query();
        $query->leftJoin('organization', 'organization.id', '=', 'issue.id_org');
        $query->leftJoin('type_statfollowup_issue', 'type_statfollowup_issue.id', '=', 'issue.followup_status');
        $query->leftJoin('kci', 'kci.id', '=', 'issue.id_kci');
        $query->leftJoin('kpi', 'kpi.id', '=', 'issue.id_kpi');
        $query->leftJoin('kri', 'kri.id', '=', 'issue.id_kri');
        $query->leftJoin('controls_activity', 'controls_activity.id', '=', 'issue.id_control_activity');
        $query->leftJoin('risk_registers', 'risk_registers.id', '=', 'issue.id_risk_register');
        $query->leftJoin('issue_category', 'issue_category.id', '=', 'issue.category');
        $query->leftJoin('type_issue', 'type_issue.id', '=', 'issue.type');
        $query->leftJoin('issue_information_source', 'issue_information_source.id', '=', 'issue.information_source');

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(issue.title LIKE '%" . $rq["search_name"] . "%')");
        }

        if (isset($request->status)) {
            $query->where("type_statfollowup_issue.id", $request->status);
        }

        $query->select(
            'issue.id',
            'issue.title',
            'issue.ofi',
            'issue.followup_status',
            'issue.recomendation',
            'issue.target_date',
            'organization.id as id_org',
            'organization.name_org',
            'type_statfollowup_issue.name_status as status_name',
            'type_statfollowup_issue.style_status as status_style',
            'kpi.id as kpi_id',
            'kci.id as kci_id',
            'kri.id as kri_id',
            'controls_activity.id as controls_activity_id',
            'risk_registers.id as risk_register_id',
            'type_issue.name_type_issue as type',
            'issue_category.name_category_issue as category',
            'issue_information_source.name_information_source',
        );

        $issue = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $audit_trails = Log::where('page', "Compliance Category")->orderBy('created_at', 'asc')->get();
        $data_status_mappings = TypeStatfollowupIssue::get();
        return view('pages.control.issues.index', [
            'issue' => $issue,
            'access' => $access,
            'audit_trails' => $audit_trails,
            'user' => $user,
            'status_mapping' => $data_status_mappings,
            'pagination' => json_decode(json_encode($issue))
        ]);
    }

    public function addViewIssue()
    {
        $getIssue = Organization::leftJoin('users', 'users.id', '=', 'organization.lead_role')
            ->select('organization.id', 'organization.name_org')->get();
        $stat = TypeStatfollowupIssue::get();
        $cate = TypeCategoryIssue::get();
        $type = TypeIssues::get();

        if (sizeof($getIssue) != 0) {
            return response()->json([
                "success" => true,
                "data" => $getIssue,
                "stat" => $stat,
                "cate" => $cate,
                "type" => $type,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "stat" => [],
                "cate" => [],
                "type" => [],
            ]);
        }
    }

    public function generateKciIssue(Request $request, $id)
    {
        // Auth::user();
        $rq = $request->all();

        if ($rq["title"] == null || $rq["title"] == "") {
            return response()->json([
                "success" => false,
                "message" => "Title Kosong! Isi title terlebih dulu!",
            ]);
        } elseif (!isset($rq["title"])) {
            return response()->json([
                "success" => false,
                "message" => "Field title tidak ada dan harus diisi!",
            ]);
        }

        $dataAddIssue = [
            'id_kci' => $id,
            'title' => $rq['title'],
            'followup_status' => 1,
            'recomendation' => "Mohon Di Isi!",
            'ofi' => "Mohon Di Isi!",
            'information_source' => 7,
            'type' => 1,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        try {
            $issue = Issue::create($dataAddIssue);

            if (isset($issue->id)) {
                // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                //     ->where('roles.id', 3)
                //     ->get();

                // foreach ($email as $data) {
                //     Utility::notif("Compliance Obligations", $request, $data, $email);
                // }

                // Utility::log("Compliance Obligations", $user, $getdetails->likelihood_id, $email, "RESUBMITTED");

                return response()->json([
                    "success" => true,
                    "data" => $issue,
                    "message" => "Sukses Generate Issue dari KCI!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => $issue,
                    "message" => "Gagal Generate Issue dari KCI!",
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

    public function saveIssue(Request $request)
    {
        $rq = $request->all();
        // Auth::user();
        // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
        //     ->where('roles.id', 3)
        //     ->get();

        // foreach ($email as $data) {
        //     Utility::notif("Compliance Obligations", $request, $data, $email);
        // }

        // Utility::log("Compliance Obligations", $user, $getdetails->likelihood_id, $email, "RESUBMITTED");

        if (empty($rq["status"]) || empty($rq["title_issue"]) || empty($rq["type_issue"]) || empty($rq["category_issue"]) || empty($rq['org']) || empty($rq["source_id"])) {
            return response()->json([
                "success" => false,
                "message" => "Followup Status, Type, Title,  Category, Organization, Dan Information Source Tidak boleh kosong!"
            ]);
        } else {
            $dataAddIssue = [
                'id_org' => $rq['org'],
                'title' => $rq["title_issue"],
                'followup_status' => $rq["status"],
                'recomendation' => $rq["recomdn_issue"],
                'category' => $rq["category_issue"],
                'ofi' => $rq["ofi_issue"],
                'target_date' => $rq["date_issue"],
                'information_source' => $rq["source_id"],
                'type' => $rq["type_issue"],
                "created_at" => date("Y-m-d H:i:s"),
            ];

            $issue = Issue::create($dataAddIssue);

            return response()->json([
                "success" => true,
                "data" => $issue,
                "message" => "Berhasil Buat Data Issue"
            ]);
        }
    }

    public function detailsIssue(\App\Library\GroupPermissions $userdata, $id)
    {
        $access = [
            'add' => $userdata->hasPermission('add issues'),
            'view' => $userdata->hasPermission('view issues'),
            'update' => $userdata->hasPermission('update issues'),
            'delete' => $userdata->hasPermission('delete issues'),
            'approval' => $userdata->hasPermission('approval issues'),
            'reviewer' => $userdata->hasPermission('reviewer issues'),
        ];
        $getIssue = json_decode(json_encode(Issue::where("id", $id)->first()), true);
        $getInfo = json_decode(json_encode(IssueInformationSource::where("id", $getIssue["information_source"])->first()), true);
        $getStatus = json_decode(json_encode(TypeStatfollowupIssue::where("id", $getIssue["followup_status"])->first()), true);
        $getType = json_decode(json_encode(TypeIssues::where("id", $getIssue["type"])->first()), true);
        $getOrg = json_decode(json_encode(Organization::where("id", $getIssue["id_org"])->first()), true);

        if (isset($getIssue["category"])) {
            $getCate = json_decode(json_encode(TypeCategoryIssue::where("id", $getIssue["category"])->first()), true);
        } else {
            $getCate = [];
        }

        $dataInfo["information_source"] = $getInfo;
        $dataStatus["followup_status"] = $getStatus;
        $dataType["type"] = $getType;
        $dataCate["category"] = $getCate;
        $dataOrg["organization"] = $getOrg;

        $mergeIssue = array_merge($getIssue, $dataInfo, $dataStatus, $dataType, $dataCate, $dataOrg);

        if (isset($mergeIssue["id"])) {
            return response()->json([
                "success" => true,
                "data" => $mergeIssue,
                'access' => $access,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $mergeIssue,
                'access' => [],
                "message" => "",
            ]);
        }
    }

    public function editViewIssue($id)
    {
        $getIssue = json_decode(json_encode(Issue::where("id", $id)->first()), true);
        $getInfo = json_decode(json_encode(IssueInformationSource::where("id", $getIssue["information_source"])->first()), true);
        $getStatus = json_decode(json_encode(TypeStatfollowupIssue::where("id", $getIssue["followup_status"])->first()), true);
        $getType = json_decode(json_encode(TypeIssues::where("id", $getIssue["type"])->first()), true);
        $getOrg = json_decode(json_encode(Organization::where("id", $getIssue["id_org"])->first()), true);

        if (isset($getIssue["category"])) {
            $getCate = json_decode(json_encode(TypeCategoryIssue::where("id", $getIssue["category"])->first()), true);
        } else {
            $getCate = [];
        }

        $dataInfo["information_source"] = $getInfo;
        $dataStatus["followup_status"] = $getStatus;
        $dataType["type"] = $getType;
        $dataCate["category"] = $getCate;
        $dataOrg["organization"] = $getOrg;

        $mergeIssue = array_merge($getIssue, $dataInfo, $dataStatus, $dataType, $dataCate, $dataOrg);

        if (isset($mergeIssue["id"])) {
            return response()->json([
                "success" => true,
                "data" => $mergeIssue,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $mergeIssue,
                "message" => "",
            ]);
        }
    }

    public function editSaveIssue(Request $request, $id)
    {
        $rq = $request->all();
        $dataEditIssue = [
            'id_org' => $rq['org'],
            'title' => $rq["title_issue"],
            'followup_status' => $rq["status"],
            'recomendation' => $rq["recomendation_issue"],
            'category' => $rq["category_issue"],
            'ofi' => $rq["ofi_issue"],
            'target_date' => $rq["date_issue"],
            'type' => $rq["type_issue"],
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        $issue = Issue::where('id', $id)->update($dataEditIssue);

        // Auth::user();
        // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
        //     ->where('roles.id', 3)
        //     ->get();

        // foreach ($email as $data) {
        //     Utility::notif("Compliance Obligations", $request, $data, $email);
        // }

        // Utility::log("Compliance Obligations", $user, $getdetails->likelihood_id, $email, "RESUBMITTED");

        if ($issue == 1) {
            return response()->json([
                "success" => true,
                "data" => $issue,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function delete(Request $request, $id)
    {
        $rq = $request->all();
        if (!empty($rq['reasonIssue'])) {
            $delIssue = Issue::where('id', $id)->delete();
            return response()->json([
                "success" => true,
                "data" => $delIssue,
                "message" => "Issue has been Deleted!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Reason Can't Empty!",
            ]);
        }
    }

    public function getInfoSource()
    {
        $getInfo = IssueInformationSource::get();

        if (sizeof($getInfo) != 0) {
            return response()->json([
                "success" => true,
                "data" => $getInfo,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getInfo,
            ]);
        }
    }

    public function exportData()
    {

        $query = Issue::query();
        $query->leftJoin('organization', 'organization.id', '=', 'issue.id_org');
        $query->leftJoin('type_statfollowup_issue', 'type_statfollowup_issue.id', '=', 'issue.followup_status');
        $query->leftJoin('type_issue', 'type_issue.id', '=', 'issue.type');
        $query->leftJoin('issue_information_source', 'issue_information_source.id', '=', 'issue.information_source');

        $query->select(
            'issue.id',
            'issue.title',
            'issue.target_date',
            'organization.name_org',
            'type_statfollowup_issue.name_status as status_name',
            'type_issue.name_type_issue as type',
            'issue_information_source.name_information_source',
        );

        $issue = $query
            ->orderBy("id", "ASC")
            ->get();

        return Excel::download(new IssueExprt($issue), 'Issue-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
