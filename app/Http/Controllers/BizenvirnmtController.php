<?php

namespace App\Http\Controllers;

use App\Library\Facades\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Governances\{
    Policies,
    Capabilities,
    Periods,
};
use App\Models\{
    Environment,
    Log,
    User,
};
use App\Models\General\{
    StatusMapping as Status,
    ReviewLogs as Review,
};
use App\Exports\Governances\BizEnv;
use Maatwebsite\Excel\Facades\Excel;

class BizenvirnmtController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add biz_environment'),
            'view' => $userdata->hasPermission('view biz_environment'),
            'update' => $userdata->hasPermission('update biz_environment'),
            'delete' => $userdata->hasPermission('delete biz_environment'),
            'approval' => $userdata->hasPermission('approval biz_environment'),
            'reviewer' => $userdata->hasPermission('reviewer biz_environment'),
        ];

        $query = Environment::query();

        if (isset($request->search_data)) {
            $query->where("name_environment", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where('id_organization', $user->org_id);
        }

        $dataBzenvir = $query->orderBy("id", "DESC")->paginate(10)->toArray();

        $arrbzenvir = [];
        foreach ($dataBzenvir["data"] as $key => $bzenv) {
            $getPols = Policies::where("id_bizenv", $bzenv["id"])->first();
            $getStatus = DB::table('status_mapping')->where("id", $bzenv["status"])->first();
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Biz Environment")->where("module_id", $bzenv["id"])->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get();

            $dataMergeBizEnv = [
                "id" => $bzenv["id"],
                "name_environment" => $bzenv["name_environment"],
                "period" => $bzenv["period"],
                "id_organization" => $bzenv["id_organization"],
                "business_activity" => $bzenv["business_activity"],
                "type" => $bzenv["type"],
                "effect" => $bzenv["effect"],
                "status" => $bzenv["status"],
                "status_map" => $getStatus,
                "source" => $bzenv["source"],
                "current_change" => $bzenv["current_change"],
                "influenced_capabilities_process" => $bzenv["influenced_capabilities_process"],
                "influenced_capabilities_people" => $bzenv["influenced_capabilities_people"],
                "influenced_capabilities_tools" => $bzenv["influenced_capabilities_tools"],
                "influenced_capabilities_resources" => $bzenv["influenced_capabilities_resources"],
                "trend_analysis" => $bzenv["trend_analysis"],
                "description" => $bzenv["description"],
                "notes" => $getReview,
                "policies" => $getPols,
                "created_at" => $bzenv["created_at"],
            ];
            array_push($arrbzenvir, $dataMergeBizEnv);
        }

        $toJson = json_encode($arrbzenvir);
        $bzenvir = json_decode($toJson);
        $coreBizAct = Capabilities::where('org_id', $user->org_id)->get();

        $data_organization = DB::table('organization')->get();
        $data_corebizactivity = DB::table('capabilities')->get();
        $data_environment = Environment::get();
        $data_effect_environment = DB::table('effect_environment')->get();
        $data_current_change = DB::table('current_change')->get();
        $data_type_governance = DB::table('type_governance')->get();
        $data_periods = DB::table('periods')->get();
        $data_status_mapping = DB::table('status_mapping')->get();
        $audit_trails = Log::where('page', "Biz Environment")->orderBy('created_at', 'asc')->get();

        return view('pages.governance.biz_environment.index')
            ->with('biz_environment', $bzenvir)
            ->with('pagination', json_decode(json_encode($dataBzenvir)))
            ->with('organization', $data_organization)
            ->with('corebizactivity', $data_corebizactivity)
            ->with('core', $coreBizAct)
            ->with('periods', $data_periods)
            ->with('environment', $data_environment)
            ->with('type_governance', $data_type_governance)
            ->with('effect_environment', $data_effect_environment)
            ->with('current_change', $data_current_change)
            ->with('audit_trails', $audit_trails)
            ->with('access', $access)
            ->with('status_mapping', $data_status_mapping);
    }

    public function getPeriod(Request $request)
    {
        $data['period'] = Periods::where("id_capabilities", $request->id_period)
            ->get(["name_periods", "id"]);
        return response()->json($data);
    }

    public function add(Request $request)
    {

        try {

            DB::beginTransaction();
            $user = Auth::user();
            $insert = [
                'name_environment' => $request->name_environment,
                'id_organization' => $user->org_id,
                'period' => $request->id_period,
                'business_activity' => $request->id_corebizactivity,
                'effect' => $request->effect,
                'source' => $request->source,
                'type' => $request->id_type,
                'current_change' => $request->current_change,
                'influenced_capabilities_process' => $request->influenced_capabilities_process,
                'influenced_capabilities_people' => $request->influenced_capabilities_people,
                'influenced_capabilities_tools' => $request->influenced_capabilities_tools,
                'influenced_capabilities_resources' => $request->influenced_capabilities_resources,
                'description' => $request->description,
                'status' => 1
            ];

            $createEnv = Environment::create($insert);
            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 2)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Biz Environment", $request, $data, "CREATED");
            }

            Utility::log("Biz Environment", $user, $createEnv->id, $email, "CREATED");

            return redirect('bizenvirnmt')->with('addbiz', 'Data Environment berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('bizenvirnmt')->with('addbiz', 'Data Environment gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {

        try {

            DB::beginTransaction();
            $user = Auth::user();

            $update = [
                'name_environment' => $request->name_environment,
                'id_organization' => $user->org_id,
                'period' => $request->id_period,
                'business_activity' => $request->id_corebizactivity,
                'effect' => $request->effect,
                'source' => $request->source,
                'type' => $request->id_type,
                'current_change' => $request->current_change,
                'influenced_capabilities_process' => $request->influenced_capabilities_process,
                'influenced_capabilities_people' => $request->influenced_capabilities_people,
                'influenced_capabilities_tools' => $request->influenced_capabilities_tools,
                'influenced_capabilities_resources' => $request->influenced_capabilities_resources,
                'description' => $request->description,
                'status' => 3
            ];

            Environment::where('id', $id)->update($update);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();


            foreach ($email as $data) {
                Utility::notif("Biz Environment", $request, $data, "RESUBMITTED");
            }

            Utility::log("Biz Environment", $user, $id, $email, "RESUBMITTED");

            return redirect('bizenvirnmt')->with('update', 'Data Biz Environment berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('bizenvirnmt')->with('update', 'Data Biz Environment gagal diupdate.');
        }
    }

    public function delete($id)
    {
        DB::table('biz_environment')->where('id', $id)->delete();
        return redirect('bizenvirnmt')->with('delete', 'Data biz berhasil dihapus.');
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

                Environment::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Biz Environment", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Biz Environment", $request, $data, "APPROVED");
                }

                Utility::log("Biz Environment", $user, $id, $email, "APPROVED");
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                Environment::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Biz Environment", $id, $user, $request->revnotes, "Recheck");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Biz Environment", $request, $data, "REJECTED");
                }

                Utility::log("Biz Environment", $user, $id, $email, "REJECTED");
            }

            return redirect('bizenvirnmt')->with('approve', 'Data Biz Environment berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('bizenvirnmt')->with('approve', 'Data Biz Environment gagal diupdate.');
        }
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $query = Environment::query();

        if (isset($request->search_data)) {
            $query->where("name_environment", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        $dataBzenvir = $query->get()->toArray();

        $arrbzenvir = [];
        foreach ($dataBzenvir as $key => $bzenv) {
            $getPols = Policies::where("id_bizenv", $bzenv["id"])->first();
            $getStatus = Status::where("id", $bzenv["status"])->first();
            $getCapab = Capabilities::where("id", $bzenv["business_activity"])->first();
            $data_type_governance = DB::table('type_governance')->where("id", $bzenv["type"])->first();
            $data_periods = DB::table('periods')->where("id", $bzenv["period"])->first();
            
            $dataMergeBizEnv = [
                "id" => $bzenv["id"],
                "name_environment" => $bzenv["name_environment"],
                "period" => isset($data_periods->name_periods) ? $data_periods->name_periods : "-",
                "business_activity" => isset($getCapab->name) ? $getCapab->name : "-",
                "type" => isset($data_type_governance->environment) ? $data_type_governance->environment : "-",
                "status" => isset($getStatus->status) ? $getStatus->status : "-",
                "source" => $bzenv["source"],
                "created_at" => $bzenv["created_at"],
            ];
            array_push($arrbzenvir, $dataMergeBizEnv);
        }

        $toJson = json_encode($arrbzenvir);
        $bzenvir = json_decode($toJson);

        return Excel::download(new BizEnv($bzenvir), 'biz_environment-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
