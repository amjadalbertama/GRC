<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\Facades\Utility;
use App\Models\Governances\{
    Capabilities,
    Organization,
    Periods
};
use App\Models\General\{
    StatusMapping as Status,
    ReviewLogs as Review,
};
use App\Models\{
    Objectegory,
    RiskAppetite,
    Objective,
    RiskThreshold,
    Log,
    User,
};
use App\Models\Risks\{
    ImpactCriteria,
};

class RiskAppetiteController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add risk_appetite'),
            'view' => $userdata->hasPermission('view risk_appetite'),
            'update' => $userdata->hasPermission('update risk_appetite'),
            'delete' => $userdata->hasPermission('delete risk_appetite'),
            'approval' => $userdata->hasPermission('approval risk_appetite'),
            'reviewer' => $userdata->hasPermission('reviewer risk_appetite'),
        ];

        $query = RiskAppetite::query();

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where('org_id', $user->org_id);
        }

        $risk_app = $query->orderBy('id', 'DESC')->paginate(10);

        $data_periods = Periods::get();
        $data_corebizactivity = Capabilities::get();
        $data_organization = Organization::get();
        $data_status_mapping = Status::get();
        $data_objectegory = Objectegory::get();
        $data_audit_trails = Log::where('page', "Risk Appetite")->orderBy('created_at', 'asc')->get();

        return view('pages.risk.risk_appetites.index')
            ->with('objectegory', $data_objectegory)
            ->with('capabilities', $data_corebizactivity)
            ->with('periods', $data_periods)
            ->with('access', $access)
            ->with('organization', $data_organization)
            ->with('audit_trails', $data_audit_trails)
            ->with('status_mapping', $data_status_mapping)
            ->with('risk_appetite', $risk_app)
            ->with('pagination', json_decode(json_encode($risk_app)));
    }

    public function getViewCategory($id)
    {
        $user = Auth::user();

        $risk_app_cat = json_decode(json_encode(RiskAppetite::where('id', $id)->first()), true);
        $getObj = json_decode(json_encode(Objective::where("id", $risk_app_cat["id_objective"])->first()), true);
        $getObjCat["objective_category"] = json_decode(json_encode(Objectegory::where("id", $getObj["id_category"])->first()), true);
        $getStatus["status"] = Status::where("id", $risk_app_cat["status"])->first();
        $mergeObj["objective"] = array_merge($getObj, $getObjCat);
        $data_risk_threshold["risk_threshold"] = RiskThreshold::where('id_risk_appetite', $id)->get();
        $data_impact_criteria["impact_criteria"] = json_decode(json_encode(ImpactCriteria::select("id", "title")->where("risk_app_id", $id)->first()), true);
        $getReview["notes"] = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Risk Appetite")->where("module_id", $id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

        $mergedRiskApp = array_merge($risk_app_cat, $getStatus, $mergeObj, $data_impact_criteria, $data_risk_threshold, $getReview);

        return view('pages.risk.risk_appetites.category')
            ->with('rat', json_decode(json_encode($mergedRiskApp)));
    }

    public function generateRA(Request $request)
    {
        $rq = $request->all();

        $checkObjId = RiskAppetite::where("id_objective", $rq["id_objective"])->first();

        if (isset($checkObjId->id_objective)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data RiskAppetite dengan ID Objective ini sudah ada!",
            ]);
        }

        try {

            DB::beginTransaction();

            $getBizEnv = Objective::where("id", $rq["id_objective"])->first();
            $user = Auth::user();

            if (isset($getBizEnv->id)) {
                $dataPol = [
                    'status' => 1,
                    'org_id' => $user->org_id,
                    'id_objective' => $getBizEnv->id,
                ];

                $generatePol = RiskAppetite::create($dataPol);
                $data_details = array(
                    array(
                        "id_risk_appetite" => $generatePol->id,
                        "deviasi_order" => 1,
                        "color" => '#b4c8eb',
                        "deviasi" => 10,
                        "type" => 'Acceptable',
                        "description" => 'Slight deviation',
                        "status" => 'INSIGNIFICANT',
                    ),
                    array(
                        "id_risk_appetite" => $generatePol->id,
                        "deviasi_order" => 2,
                        "color" => '#c6e6b1',
                        "deviasi" => 10,
                        "type" => 'Limited deviation',
                        "description" => 'Tolerable',
                        "status" => 'MINOR',

                    ),
                    array(
                        "id_risk_appetite" => $generatePol->id,
                        "deviasi_order" => 3,
                        "color" => '#ffffcc',
                        "deviasi" => 15,
                        "type" => 'Not Tolerable',
                        "description" => 'Minor deviation',
                        "status" => 'MODERATE',

                    ),
                    array(
                        "id_risk_appetite" => $generatePol->id,
                        "deviasi_order" => 4,
                        "color" => '#ffefcc',
                        "deviasi" => 20,
                        "type" => 'Not Tolerable',
                        "description" => 'Major deviation',
                        "status" => 'SIGNIFICANT',

                    ),
                    array(
                        "id_risk_appetite" => $generatePol->id,
                        "deviasi_order" => 5,
                        "color" => '#ffcccc',
                        "deviasi" => 25,
                        "type" => 'Extensive deviation',
                        "description" => 'Not Tolerable',
                        "status" => 'CATASTROPHIC',

                    )
                );
                $new_insert_array = array();
                foreach ($data_details as $key => $data) {
                    $new_insert_array[] = array(
                        'id_risk_appetite' => $data['id_risk_appetite'],
                        'color' => $data['color'],
                        'deviasi' => $data['deviasi'],
                        'deviasi_order' => $data['deviasi_order'],
                        'type' => $data['type'],
                        'description' => $data['description'],
                        'status' => $data['status'],
                    );
                }
                RiskThreshold::insert($new_insert_array);
                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 3)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Risk Appetite", $request, $data, "CREATED FROM GENERATE OBJECTIVE");
                }

                Utility::log("Risk Appetite", $user, $generatePol->id, $email, "CREATED FROM GENERATE OBJECTIVE");


                return response()->json([
                    "success" => true,
                    "data" => $generatePol,
                    "message" => "Data Risk Appetite berhasil di generate!",
                ]);
            } else {
                return response()->json([
                    "success" => true,
                    "data" => [],
                    "message" => "Data Risk Appetite gagal di generate!",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => $e,
                "message" => "Data Risk Appetite gagal di generate!",
            ]);
        }
    }

    public function update(Request $request, $id)
    {

        // print_r(($id));die;
        DB::beginTransaction();

        $updaterat = [
            'risk_capacity' => $request->capacity,
            'risk_appetite' => $request->appetite,
            'risk_tolerance' => $request->tolerance,
            'risk_limit' => $request->limit,
            'status' => 3
        ];
        RiskAppetite::where('id', $id)->update($updaterat);

        $deviasi_order1 = [
            'deviasi' => $request->deviasi_order1,
            'color' => $request->color_deviasi_order1
        ];
        $deviasi_order2 = [
            'deviasi' => $request->deviasi_order2,
            'color' => $request->color_deviasi_order2
        ];
        $deviasi_order3 = [
            'deviasi' => $request->deviasi_order3,
            'color' => $request->color_deviasi_order3
        ];
        $deviasi_order4 = [
            'deviasi' => $request->deviasi_order4,
            'color' => $request->color_deviasi_order4
        ];
        $deviasi_order5 = [
            'deviasi' => $request->deviasi_order5,
            'color' => $request->color_deviasi_order5
        ];

        RiskThreshold::where('id_risk_appetite', $id)->where('deviasi_order', 1)->update($deviasi_order1);
        RiskThreshold::where('id_risk_appetite', $id)->where('deviasi_order', 2)->update($deviasi_order2);
        RiskThreshold::where('id_risk_appetite', $id)->where('deviasi_order', 3)->update($deviasi_order3);
        RiskThreshold::where('id_risk_appetite', $id)->where('deviasi_order', 4)->update($deviasi_order4);
        RiskThreshold::where('id_risk_appetite', $id)->where('deviasi_order', 5)->update($deviasi_order5);

        DB::commit();
        return redirect()->route('risk_appetite_category', ['id' => $id])->with('update', 'Data risk_appetite_category berhasil diupdate.');
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

                RiskAppetite::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Risk Appetite", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Risk Appetite", $request, $data, "APPROVED");
                }

                Utility::log("Risk Appetite", $user, $id, $email, "APPROVEDS");
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                RiskAppetite::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Risk Appetite", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Risk Appetite", $request, $data, "REJECTED");
                }

                Utility::log("Risk Appetite", $user, $id, $email, "REJECTED");
            }
            return redirect('risk_appetite')->with('approve', 'Data risk appetite berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('risk_appetite')->with('approve', 'Data risk appetite gagal diupdate.');
        }
    }
}
