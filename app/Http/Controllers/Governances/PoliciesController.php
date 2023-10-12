<?php

namespace App\Http\Controllers\Governances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Library\Facades\Utility;
use App\Models\{
    User,
    Objectegory,
};
use App\Models\Governances\{
    Periods,
    Policies,
    PoliciesKpi,
    BizEnvironment,
    TypeGovernances,
    Organization,
    Kpi,
};
use App\Models\General\{
    StatusMapping,
    ReviewLogs as Review,
};
use Illuminate\Support\Facades\DB;
use App\Exports\Governances\PoliciesExport;
use Maatwebsite\Excel\Facades\Excel;

class PoliciesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['addKpi']]);
    }

    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add policies'),
            'view' => $userdata->hasPermission('view policies'),
            'update' => $userdata->hasPermission('update policies'),
            'delete' => $userdata->hasPermission('delete policies'),
            'approval' => $userdata->hasPermission('approval policies'),
            'reviewer' => $userdata->hasPermission('reviewer policies'),
        ];

        $query = Policies::query();

        if (isset($request->search_data)) {
            $query->where("title", "LIKE", "%".$request->search_data."%");
        }

        if (isset($request->status)) {
            $query->where("id_status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where("id_org", $user->org_id);
        }

        $getPolicies = $query->orderBy("id", "DESC")->paginate(10)->toArray();

        $arrPol = [];
        foreach ($getPolicies["data"] as $key => $pl) {
            $data_status_mapping = StatusMapping::where("id", $pl["id_status"])->first();
            $data_type = TypeGovernances::where("id", $pl["types"])->first();
            $data_periods = Periods::where("id", $pl["id_period"])->first();
            $data_organization = Organization::where("id", $pl["id_org"])->first();
            $data_kpi = PoliciesKpi::where("id_policies", $pl["id"])->get()->toArray();
            $kpi_main = Kpi::where("id_policies", $pl["id"])->get();
            $data_category = Objectegory::where("id", $pl["id_category"])->first();
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Policies")->where("module_id", $pl["id"])->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get();
            $dataPolicies = [
                'id' => $pl["id"],
                'title' => $pl["title"],
                'description' => $pl["description"],
                'types' => $data_type,
                'periods' => $data_periods,
                'organization' => $data_organization,
                'status' => $data_status_mapping,
                'id_bizenv' => $pl["id_bizenv"],
                'capacity' => $pl["capacity"],
                'tolerance' => $pl["tolerance"],
                'appetite' => $pl["appetite"],
                'target' => $pl["target"],
                'smart_objective' => $pl["smart_objective"],
                'dos' => $pl["dos"],
                'donts' => $pl["donts"],
                'id_category' => $pl["id_category"],
                'category' => $data_category,
                'id_objective' => $pl["id_objective"],
                'notes' => $getReview,
                'kpis' => [
                    "total" => array_sum(array_column($data_kpi, 'percentage')),
                    "data" => $data_kpi
                ],
                'created_at' => $pl["created_at"],
                'main_kpi' => $kpi_main,
            ];

            array_push($arrPol, $dataPolicies);
        }

        $listTypePolicies = TypeGovernances::get();
        $getObjCat = Objectegory::where("id_organization", "=", 0)->orWhere("id_organization", $user->org_id)->where("status", "=", 5)->get();

        $listObjCat = sizeof($getObjCat) > 0 ? $getObjCat : null;

        $dataArrPolicies = [
            "data" => $arrPol,
            "meta_data" => [
                "type_policies" => $listTypePolicies,
                "objective_categories" => $listObjCat,
            ]
        ];

        $toJsonPol = json_encode($dataArrPolicies);
        $policies = json_decode($toJsonPol);

        $data_status_mappings = StatusMapping::get();

        return view('pages.governance.policies.index', [
            'policies' => $policies,
            'access' => $access,
            'status_mapping' => $data_status_mappings,
            'pagination' => json_decode(json_encode($getPolicies)),
        ]);
    }

    public function getView_as()
    {
        $policies = Policies::paginate(20);
        return view('pages-assesment.governance.policies.index', ['policies' => $policies]);
    }

    public function addData($id_bizact)
    {
        $getBizEnv = BizEnvironment::where("id", $id_bizact)->first();

        $dataIns = [
            'title' => $getBizEnv->name_environment,
            // 'description' => $request->desc,
            // 'types' => $request->types,
            'id_period' => $getBizEnv->id_period,
            'id_org' => $getBizEnv->id_org,
            'id_status' => 1,
            'id_bizact' => $getBizEnv->id_bizact,
            'id_bizenv' => $getBizEnv->id_bizenv,
            // 'capacity' => $request->capacity,
            // 'tolerance' => $request->tolerance,
            // 'appetite' => $request->appetite,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $insDat = Policies::insert([
            'title' => $request->title,
            'description' => $request->desc,
            'types' => $request->types,
            'id_period' => $request->id_period,
            'id_org' => $request->id_org,
            'id_status' => 1,
            'id_bizact' => $request->id_bizact,
            'id_bizenv' => $request->id_bizenv,
            'capacity' => $request->capacity,
            'tolerance' => $request->tolerance,
            'appetite' => $request->appetite,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return redirect('policies')->with('addorg', 'Data policies  berhasil ditambahkan.');
    }

    public function add_as(Request $request)
    {
        Policies::insert([
            'title' => $request->title,
            'description' => $request->desc,
            'types' => $request->types,
            'id_period' => $request->id_period,
            'id_org' => $request->id_org,
            'id_status' => 1,
            'id_bizact' => $request->id_bizact,
            'id_bizenv' => $request->id_bizenv,
            'capacity' => $request->capacity,
            'tolerance' => $request->tolerance,
            'appetite' => $request->appetite,
            'created_at' => strtotime(date("Y-m-d H:i:s")),
        ]);

        return redirect('policies_as')->with('addorg', 'Data policies  berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $message = [
            "types.required" => "Type is required, you have to choose 1 from options!",
            "types.not_in" => "You have to choose Type other than this from options!",
            "objcat.required" => "Category ID is required, you have to choose 1 from options!",
            "objcat.not_in" => "You have to choose Category other than this from options!",
            // "organization_id.not_in" => "You have to choose Organization other than this from options!",
        ];

        $validator = Validator::make($request->all(), [
            "types" => "required|not_in:0",
            "objcat" => "required|not_in:0",
        ], $message)->validate();

        $dataUpdPol = [
            'title' => $request->title,
            'description' => $request->desc,
            'types' => $request->types,
            'id_category' => $request->objcat,
            'dos' => $request->dos,
            'donts' => $request->donts,
            'capacity' => $request->capacity,
            'appetite' => $request->appetite,
            'tolerance' => $request->tolerance,
            'target' => $request->target,
            'smart_objective' => $request->smart_objective,
            'id_status' => 3,
            // 'id_objective' => $request->id_objective,
        ];

        $updPol = Policies::where('id', $id)->update($dataUpdPol);

        if ($updPol == 1) {
            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Policies", $request, $data, "RESUBMITTED");
            }

            Utility::log("Policies", $user, $id, $email, "RESUBMITTED");

            return redirect('policies')->with('update', 'Data policies berhasil diperbarui.');
        } else {
            return redirect('policies')->with('failapprove', 'Data policies tidak ada yang diperbarui.');
        }
    }

    public function update_as(Request $request, $id)
    {

        Policies::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'id_objective' => $request->id_objective,
            'name_org' => $request->name_org,
            'period' => $request->period,
            'status' => $request->status,
            'name_pic' => $request->name_pic,
        ]);

        return redirect('policies_as')->with('update', 'Data policies  berhasil diperbarui.');
    }

    public function delete($id)
    {
        Policies::where('id', $id)->delete();
        return redirect('policies')->with('delete', 'Data policies berhasil dihapus.');
    }

    public function delete_as($id)
    {
        Policies::where('id', $id)->delete();
        return redirect('policies_as')->with('delete', 'Data policies berhasil dihapus.');
    }

    public function generate(Request $request, $id)
    {

        DB::table('risk_appetite')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'id_objective' => $request->id_objective,
            'name_org' => $request->name_org,
            'period' => $request->period,
            'status' => $request->status,
            'name_pic' => $request->name_pic,
        ]);

        return redirect('risk_appetite')->with('update', 'Data policies  berhasil diperbarui.');
    }

    public function generatePolicy(Request $request)
    {
        $rq = $request->all();

        $user = Auth::user();

        $checkBizEnvId = Policies::where("id_bizenv", $rq["id_bizenv"])->first();

        if (isset($checkBizEnvId->id_bizenv)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Policies dengan ID Biz Environment ini sudah ada!",
            ]);
        }

        $getBizEnv = BizEnvironment::where("id", $rq["id_bizenv"])->first();

        if (isset($getBizEnv->id)) {
            $dataPol = [
                'title' => $getBizEnv->name_environment,
                'description' => $getBizEnv->description,
                'types' => $getBizEnv->type,
                'id_period' => $getBizEnv->period,
                'id_org' => $getBizEnv->id_organization,
                'id_status' => 1,
                'id_bizenv' => $getBizEnv->id,
            ];

            $generatePol = Policies::create($dataPol);
            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 2)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Policies", $request, $data, "CREATED");
            }

            Utility::log("Policies", $user, $generatePol->id, $email, "CREATED");

            return response()->json([
                "success" => true,
                "data" => $generatePol,
                "message" => "Data Policies berhasil di generate!",
            ]);
        } else {
            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Data Policies gagal di generate!",
            ]);
        }
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
                    'id_status' => $status,
                ];

                $cekKpi = PoliciesKpi::where("id_policies", $id)->get();
                if (sizeof($cekKpi) == 0) {
                    DB::rollBack();
                    return redirect('policies')->with('failapprove', 'Approve Failed. Data KPI is Empty!');
                } else {
                    $updPol = Policies::where('id', $id)->update($update);

                    if ($request->revnotes != "") {
                        $createReview = Utility::reviewLog("Policies", $id, $user, $request->revnotes, "Approved");
                    }
                }

                DB::commit();

                if (sizeof($email) != 0) {
                    foreach ($email as $data) {
                        Utility::notif("Policies", $request, $data, "APPROVED");
                    }

                    Utility::log("Policies", $user, $id, $email, "APPROVED");
                }
            } elseif ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'id_status' => 2,
                ];

                $updPol = Policies::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Policies", $id, $user, $request->revnotes, "Recheck");
                }

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                if (sizeof($email) != 0) {
                    foreach ($email as $data) {
                        Utility::notif("Policies", $request, $data, "REJECTED");
                    }

                    Utility::log("Policies", $user, $id, $email, "REJECTED");
                }
            }

            if ($updPol == 1) {
                DB::commit();
                return redirect('policies')->with('success', 'Data policies berhasil diupdate.');
            } else {
                DB::rollBack();
                return redirect('policies')->with('failapprove', 'Data policies gagal diupdate.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('policies')->with('failapprove', 'Data policies gagal diupdate.');
        }
    }

    public function addKpi(Request $request)
    {
        $rq = $request->all();

        $dataKpi = [
            'id_policies' => $rq['id_policies'],
            'indicators' => $rq['indicators'],
            'metric' => $rq['metric'],
            'period' => $rq['period'],
            'percentage' => $rq['percentage'],
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $insPolKpi = PoliciesKpi::create($dataKpi);

        if (isset($insPolKpi->id)) {
            return response()->json([
                "success" => true,
                "data" => $insPolKpi,
                "message" => "Berhasil menambahkan KPI di Policies!",
            ]);
        } else {
            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Gagal menambahkan KPI di Policies!",
            ]);
        }
    }

    public function delKpiPol($id)
    {
        $delObjKpi = PoliciesKpi::where("id", $id)->delete();

        if ($delObjKpi == 1) {
            return response()->json([
                "success" => true,
                "data" => $delObjKpi,
                "message" => "Success delete this KPI!",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $delObjKpi,
                "message" => "Data KPI Objective tidak ada!",
            ]);
        }
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $query = Policies::query();

        if (isset($request->search_data)) {
            $query->where("title", "LIKE", "%".$request->search_data."%");
        }

        if (isset($request->status)) {
            $query->where("id_status", $request->status);
        }

        $getPolicies = $query->get()->toArray();

        $arrPol = [];
        foreach ($getPolicies as $key => $pl) {
            $data_status_mapping = StatusMapping::where("id", $pl["id_status"])->first();
            $data_type = TypeGovernances::where("id", $pl["types"])->first();
            $data_periods = Periods::where("id", $pl["id_period"])->first();
            $data_organization = Organization::where("id", $pl["id_org"])->first();
            $data_category = Objectegory::where("id", $pl["id_category"])->first();

            $dataPolicies = [
                'id' => $pl["id"],
                'title' => $pl["title"],
                'description' => $pl["description"],
                'types' => $data_type,
                'periods' => $data_periods,
                'organization' => $data_organization->name_org,
                'status' => $data_status_mapping,
                'created_at' => $pl["created_at"],
            ];

            array_push($arrPol, $dataPolicies);
        }

        $toJsonPol = json_encode($arrPol);
        $policies = json_decode($toJsonPol);

        return Excel::download(new PoliciesExport($policies), 'policies-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
