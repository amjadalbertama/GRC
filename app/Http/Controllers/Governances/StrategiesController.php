<?php

namespace App\Http\Controllers\Governances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\Facades\Utility;
use App\Models\Governances\{
    Strategies,
    Organization,
};
use App\Models\{
    Objective,
    Objectegory,
    User,
};
use App\Models\General\{
    StatusMapping as Status,
    ReviewLogs as Review,
};
use App\Models\Risks\{
    RiskRegisters as RR,
    RiskRegisterIdentifications as Identifications,
    RiskRegisterTreatments as Treatment,
};
use App\Exports\Governances\StrategiesExport;
use Maatwebsite\Excel\Facades\Excel;

class StrategiesController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add strategies'),
            'view' => $userdata->hasPermission('view strategies'),
            'update' => $userdata->hasPermission('update strategies'),
            'delete' => $userdata->hasPermission('delete strategies'),
            'approval' => $userdata->hasPermission('approval strategies'),
            'reviewer' => $userdata->hasPermission('reviewer strategies'),
        ];

        $query = Strategies::query();

        if (isset($request->search_data)) {
            $query->where("title", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where("id_org", $user->org_id);
        }

        $getStrategies = $query->orderBy("id", "DESC")->paginate(10)->toArray();

        $arrStr = [];
        foreach ($getStrategies["data"] as $key => $str) {

            if (isset($str["id_objective"])) {
                $getObj = Objective::where("id", $str["id_objective"])->first();
            } else {
                $getObj = [];
            }
            if (isset($getObj["id_category"])) {
                $getObjCat = Objectegory::where("id", $getObj["id_category"])->first();
            } else {
                $getObjCat = [];
            }

            $getStatus = Status::where("id", $str["status"])->first();

            $dataStr = [
                "id" => $str["id"],
                "title" => $str["title"],
                "id_objective" => $str["id_objective"],
                "status" => $getStatus,
                "objective_category" => isset($getObjCat->title) ? $getObjCat : ["id" => 0, "title" => "-"],
            ];
            array_push($arrStr, $dataStr);
        }

        $toJsonStr = json_encode($arrStr);
        $strategies = json_decode($toJsonStr);

        $getAllStatus = Status::get();

        return view('pages.governance.strategies.index', [
            'strategies' => $strategies,
            'access' => $access,
            'status_mapping' => $getAllStatus,
            'pagination' => json_decode(json_encode($getStrategies)),
        ]);
    }

    public function getStrategy(\App\Library\GroupPermissions $userdata, $id)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add strategies'),
            'view' => $userdata->hasPermission('view strategies'),
            'update' => $userdata->hasPermission('update strategies'),
            'delete' => $userdata->hasPermission('delete strategies'),
            'approval' => $userdata->hasPermission('approval strategies'),
            'reviewer' => $userdata->hasPermission('reviewer strategies'),
        ];

        $getDataStrategies = Strategies::where("id", $id)->first();

        $toJsonStr = json_encode($getDataStrategies);
        $str = json_decode($toJsonStr, true);

        $getObj = Objective::where("id", $str["id_objective"])->first();
        $getObjCat = Objectegory::where("id", $getObj['id_category'])->first();
        $getStatus = Status::where("id", $str["status"])->first();
        $getRiskRegIde = Identifications::where("id_risk_register", $str["id_risk_register"])->first();
        $getOrg = Organization::where("id", $str["id_org"])->first();
        $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Strategies")->where("module_id", $str["id"])->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get();

        $toJsonObj = json_encode($getObj);
        $obj = json_decode($toJsonObj, true);

        $toJsonObjCat = json_encode($getObjCat);
        $objCat = json_decode($toJsonObjCat, true);

        $objMerge = array_merge($obj, $objCat);

        $dataStr = [
            "id" => $str["id"],
            "title" => $str["title"],
            "id_objective" => $str["id_objective"],
            "status" => $getStatus,
            "objective" => $objMerge,
            "risk_event" => $getRiskRegIde,
            "organization" => $getOrg,
            "notes" => $getReview,
        ];

        $toJsonStr = json_encode($dataStr);
        $strategies = json_decode($toJsonStr);

        if (isset($getDataStrategies->id)) {
            return response()->json([
                "success" => true,
                "data" => $strategies,
                'access' => $access,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                'access' => $access,
            ]);
        }
    }

    public function add(Request $request)
    {
        DB::table('strategies')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'owner' => $request->owner,
            'date' => $request->date,
            'name_org' => $request->name_org,
            'status' => $request->status,
        ]);

        return redirect('strategies')->with('addorg', 'Data strategies  berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $dataUpdStr = [
            "title" => $request->title_str,
            "status" => 3,
        ];

        $updStr = Strategies::where('id', $id)->update($dataUpdStr);

        if ($updStr == 1) {
            $getStr = Strategies::where('id', $id)->first();

            if (isset($getStr->id)) {
                $updTreatment = Treatment::where("id_risk_register", $getStr->id_risk_register)->update([
                    "risk_treatment_strategy" => $getStr->title,
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => $getStr,
                    "message" => "Data Treatment dengan ID Risk Register ini tidak ada."
                ]);
            }

            return response()->json([
                "success" => true,
                "data" => $updStr,
                "message" => "Data strategies berhasil diperbarui."
            ]);
        } else {
            return response()->json([
                "success" => true,
                "data" => $updStr,
                "message" => "Data strategies gagal diperbarui."
            ]);
        }
    }

    public function delete($id)
    {
        $delStr = strategies::where('id', $id)->delete();

        return response()->json([
            "success" => true,
            "data" => $delStr,
            "message" => "Data strategies berhasil dihapus."
        ]);
    }

    public function generateStrategy(Request $request)
    {
        $dataStrat = [
            "title" => $request->strategy,
            "id_risk_register" => $request->id_risk_regis,
            "id_org" => $request->id_org,
            "id_objective" => $request->id_objective,
            "status" => 1,
            "created_at" => date("Y-m-d H:i:s"),
        ];

        try {
            $getStrategy = Strategies::where("id_risk_register", $request->id_risk_regis)->first();
            if (!isset($getStrategy->id)) {
                $strat = Strategies::create($dataStrat);

                return response()->json([
                    "success" => true,
                    "data" => $strat,
                    "message" => "Berhasil membuat Strategies!",
                ]);
            } else {
                $strat = Strategies::where("id", $getStrategy->id)->update($dataStrat);

                return response()->json([
                    "success" => true,
                    "data" => $strat,
                    "message" => "Berhasil mengubah Strategies!",
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

    public function approvalStr(Request $request, $id)
    {
        $user = Auth::user();

        try {

            DB::beginTransaction();

            if ($request->action == 'approve') {
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

                $updStrat = Strategies::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Strategies", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                if (sizeof($email) != 0) {
                    foreach ($email as $data) {
                        Utility::notif("Strategies", $request, $data, "APPROVED");
                    }

                    Utility::log("Strategies", $user, $id, $email, "APPROVED");
                }
            } elseif ($request->action == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $updStrat = Strategies::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Strategies", $id, $user, $request->revnotes, "Recheck");
                }

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                if (sizeof($email) != 0) {
                    foreach ($email as $data) {
                        Utility::notif("Strategies", $request, $data, "REJECTED");
                    }

                    Utility::log("Strategies", $user, $id, $email, "REJECTED");
                }
            }

            return response()->json([
                "success" => true,
                "data" => [
                    "status" => $updStrat,
                ],
                "message" => "Strategies telah di-update.",
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
        $user = Auth::user();

        $query = Strategies::query();

        if (isset($request->search_data)) {
            $query->where("title", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where("id_org", $user->org_id);
        }

        $getStrategies = $query->get()->toArray();

        $arrStr = [];
        foreach ($getStrategies as $key => $str) {

            if (isset($str["id_objective"])) {
                $getObj = Objective::where("id", $str["id_objective"])->first();
            } else {
                $getObj = [];
            }
            if (isset($getObj["id_category"])) {
                $getObjCat = Objectegory::where("id", $getObj["id_category"])->first();
            } else {
                $getObjCat = [];
            }

            $getStatus = Status::where("id", $str["status"])->first();

            $dataStr = [
                "id" => $str["id"],
                "title" => $str["title"],
                "id_objective" => $str["id_objective"],
                "status" => $getStatus,
                "objective_category" => isset($getObjCat->title) ? $getObjCat : ["id" => 0, "title" => "-"],
            ];
            array_push($arrStr, $dataStr);
        }

        $toJsonStr = json_encode($arrStr);
        $strategies = json_decode($toJsonStr);

        return Excel::download(new StrategiesExport($strategies), 'strategies-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}