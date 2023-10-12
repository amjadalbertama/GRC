<?php

namespace App\Http\Controllers\Compliance;

use App\Exports\Compliance\Comobg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\Compliance\{
    ComplianceObligations,
    TypeRatingCompliance
};
use App\Models\Governances\Organization;
use App\Models\Log;
use App\Models\Risks\{
    RiskRegisters as RR,
};
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class ComplianceObligationsController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();

        $user = Auth::user();
        $access = [
            'add' => $userdata->hasPermission('add compliance_obligations'),
            'view' => $userdata->hasPermission('view compliance_obligations'),
            'update' => $userdata->hasPermission('update compliance_obligations'),
            'delete' => $userdata->hasPermission('delete compliance_obligations'),
            'approval' => $userdata->hasPermission('approval compliance_obligations'),
            'reviewer' => $userdata->hasPermission('reviewer compliance_obligations'),
        ];

        $query = ComplianceObligations::query();
        $query->leftJoin('type_rating_compliance', 'type_rating_compliance.id', '=', 'compliance_obligations.rating');
        $query->leftJoin('organization', 'organization.id', '=', 'compliance_obligations.id_org');

        if (isset($request->status)) {
            $query->where("type_rating_compliance.id", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(compliance_obligations.name_obligations LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'compliance_obligations.id',
            'compliance_obligations.name_obligations',
            'compliance_obligations.compliance_source',
            'compliance_obligations.name_org',
            'compliance_obligations.compliance_owner',
            'type_rating_compliance.name_rating',
            'type_rating_compliance.style_rating'
        );

        $compliance_obligations = $query
            ->orderBy("id", "DESC")
            ->paginate(10);

        $audit_trails = Log::where('page', "Compliance Obligations")->orderBy('created_at', 'asc')->get();
        $data_status_mappings = TypeRatingCompliance::get();
        return view('pages.compliance.compliance_obligations.index', [
            'compliance_obligations' => $compliance_obligations,
            'audit_trails' => $audit_trails,
            'access' => $access,
            'status_mapping' => $data_status_mappings,
            'pagination' => json_decode(json_encode($compliance_obligations)),
        ]);
    }

    public function detailsCompOb(\App\Library\GroupPermissions $userdata, $id)
    {
        $access = [
            'add' => $userdata->hasPermission('add compliance_obligations'),
            'view' => $userdata->hasPermission('view compliance_obligations'),
            'update' => $userdata->hasPermission('update compliance_obligations'),
            'delete' => $userdata->hasPermission('delete compliance_obligations'),
            'approval' => $userdata->hasPermission('approval compliance_obligations'),
            'reviewer' => $userdata->hasPermission('reviewer compliance_obligations'),
        ];

        $getcompob  = ComplianceObligations::leftJoin('type_rating_compliance', 'type_rating_compliance.id', '=', 'compliance_obligations.rating')
            ->leftJoin('organization', 'organization.id', '=', 'compliance_obligations.id_org')
            ->where('compliance_obligations.id', $id)
            ->select(
                'compliance_obligations.id',
                'compliance_obligations.name_obligations',
                'compliance_obligations.compliance_source',
                'compliance_obligations.name_org',
                'compliance_obligations.compliance_owner',
                'type_rating_compliance.name_rating',
                'type_rating_compliance.style_rating'
            )->first();
        if (isset($getcompob)) {
            return response()->json([
                "success" => true,
                'access' => $access,
                "data" => $getcompob,
            ]);
        } else {
            return response()->json([
                "success" => false,
                'access' => $access,
                "data" => [],
            ]);
        }
    }

    public function addViewCompOb()
    {
        $getcompob = Organization::leftJoin('users', 'users.id', '=', 'organization.lead_role')
            ->select('organization.id', 'organization.name_org')->get();
        // $getArray = $getcompob->toArray();
        $array = json_decode(json_encode($getcompob), true);

        if (isset($array)) {
            return response()->json([
                "success" => true,
                "data" => $array,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }
    public function editViewCompOb($id)
    {
        $getcompob  = ComplianceObligations::leftJoin('type_rating_compliance', 'type_rating_compliance.id', '=', 'compliance_obligations.rating')
            ->leftJoin('organization', 'organization.id', '=', 'compliance_obligations.id_org')
            ->where('compliance_obligations.id', $id)
            ->select(
                'compliance_obligations.id',
                'compliance_obligations.name_obligations',
                'compliance_obligations.compliance_source',
                'compliance_obligations.name_org',
                'compliance_obligations.compliance_owner',
                'compliance_obligations.rating',
                'type_rating_compliance.name_rating',
                'type_rating_compliance.style_rating'
            )->first();
        $array_compob = json_decode(json_encode($getcompob), true);

        $org = Organization::leftJoin('users', 'users.id', '=', 'organization.lead_role')
            ->select('organization.id', 'organization.name_org')->get();
        $array_org = json_decode(json_encode($org), true);

        $rat = TypeRatingCompliance::get();
        $array_rat = json_decode(json_encode($rat), true);
        if (isset($getcompob)) {
            return response()->json([
                "success" => true,
                "data" => $array_compob,
                "org" => $array_org,
                "rat" => $array_rat,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "org" => [],
                "rat" => [],
            ]);
        }
    }

    public function showLead(Request $request)
    {
        $rq = $request->all();
        $getlead = Organization::leftJoin('users', 'users.id', '=', 'organization.lead_role')
            ->where('organization.id', $rq['id_org'])
            ->select('users.name')->first();
        // print_r($getlead);
        if (isset($getlead)) {
            return response()->json([
                "success" => true,
                "data" => $getlead,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function saveComOb(Request $request)
    {

        $rq = $request->all();
        $organis = Organization::where('id', $rq['org'])->first();
        if (!isset($organis->id)) {
            return response()->json([
                "success" => false,
                "message" => "All Field Can't Empty!"
            ]);
        } elseif (empty($rq["obligat"])) {
            return response()->json([
                "success" => false,
                "message" => "Obligations Title Field Can't Empty!"
            ]);
        } elseif (empty($rq["source"])) {
            return response()->json([
                "success" => false,
                "message" => "Compliance Source Field Can't Empty!"
            ]);
        } elseif (empty($rq["rating"])) {
            return response()->json([
                "success" => false,
                "message" => "Rating Field Can't Empty!"
            ]);
        }

        $users = User::where('id', $organis->lead_role)->first();

        $user = Auth::user();
        $dataCompOb = [
            'name_obligations' => $rq["obligat"],
            'compliance_source' => $rq["source"],
            'rating' => $rq["rating"],
            'name_org' => $organis->name_org,
            'compliance_owner' => $users->name,
            'id_org' => $user->org_id,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $compob = ComplianceObligations::create($dataCompOb);

        Auth::user();
        $email = User::join('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.id', 3)
            ->get();

        foreach ($email as $data) {
            Utility::notif("Compliance Obligations", $request, $data, $email);
        }

        Utility::log("Compliance Obligations", $user, $compob->id, $email, "CREATED");

        if (isset($compob)) {
            if ($dataCompOb == null) {
                return response()->json([
                    "success" => false,
                    "data" => $compob,
                    "message" => "Field is not Empty!"
                ]);
            } else {
                return response()->json([
                    "success" => true,
                    "data" => $compob,
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $rq = $request->all();
        $organis = Organization::where('id', $rq['org'])->first();
        $user = User::where('id', $organis->lead_role)->first();


        $dataCompOb = [
            'name_obligations' => $rq["obligat"],
            'compliance_source' => $rq["source"],
            'rating' => $rq["rating"],
            'name_org' => $organis->name_org,
            'compliance_owner' => $user->name,
            'id_org' => $user->org_id,
        ];

        $compob = ComplianceObligations::where('id', $id)->update($dataCompOb);

        Auth::user();
        $email = User::join('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.id', 2)
            ->get();

        foreach ($email as $data) {
            Utility::notif("Compliance Obligations", $request, $data, $email);
        }

        Utility::log("Compliance Obligations", $user, $id, $email, "UPDATED");
        if (isset($compob)) {
            return response()->json([
                "success" => true,
                "data" => $compob,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
            ]);
        }
    }

    public function deleteConfirmCompOb($id)
    {
        $getcompob  = ComplianceObligations::where('id', $id)->first();
        if (isset($getcompob)) {
            return response()->json([
                "success" => true,
                "data" => $getcompob,
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

        if (!empty($rq['reasonComOb'])) {
            $delCompob = ComplianceObligations::where('id', $id)->delete();
            return response()->json([
                "success" => true,
                "data" => $delCompob,
                "message" => "Compliance Obligations has been Deleted!"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Reason Can't Empty!"
            ]);
        }
    }

    public function exportData()
    {

        $query = ComplianceObligations::query();
        $query->leftJoin('type_rating_compliance', 'type_rating_compliance.id', '=', 'compliance_obligations.rating');
        $query->leftJoin('organization', 'organization.id', '=', 'compliance_obligations.id_org');
        $query->select(
            'compliance_obligations.id',
            'compliance_obligations.name_obligations',
            'compliance_obligations.compliance_source',
            'compliance_obligations.name_org',
            'type_rating_compliance.name_rating',
        );

        $compliance_obligations = $query
            ->orderBy("id", "ASC")
            ->get();

        return Excel::download(new Comobg($compliance_obligations), 'Compliance_Obligations-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
