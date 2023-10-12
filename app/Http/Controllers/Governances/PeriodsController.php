<?php

namespace App\Http\Controllers\Governances;

use App\Exports\Governances\Periods as GovernancesPeriods;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use App\Models\Governances\{
    Capabilities,
    Organization,
    Periods
};
use App\Models\Log;
use App\Models\Risks\RiskMatrix;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PeriodsController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add periods'),
            'view' => $userdata->hasPermission('view periods'),
            'update' => $userdata->hasPermission('update periods'),
            'delete' => $userdata->hasPermission('delete periods'),
            'approval' => $userdata->hasPermission('approval periods'),
            'reviewer' => $userdata->hasPermission('reviewer periods'),
        ];
        $type = [
            1 => 'Annual',
            2 => 'Semester',
            3 => 'Quarterly',
            4 => 'Monthly'
        ];
        $queryCap = Capabilities::query();
        $queryCap->leftJoin('organization', 'organization.id', '=', 'capabilities.org_id');
        $queryCap->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $queryCap->leftJoin('status_mapping', 'status_mapping.id', '=', 'capabilities.status');
        if ($user->org_id != 0) {
            $queryCap->orderBy('id', 'DESC')->where('organization.id', $user->org_id);
        }
        $queryCap->where('capabilities.status', 5);
        $queryCap->select('capabilities.id', 'capabilities.name as name_capabilities', 'organization.name_org', 'capabilities.description', 'users.name as lead_name', 'capabilities.description', 'status_mapping.status', 'status_mapping.style as status_style');
        $capabilities = $queryCap->get();

        $queryPer = Periods::query();
        $queryPer->leftJoin('capabilities', 'capabilities.id', '=', 'periods.id_capabilities');
        $queryPer->leftJoin('organization', 'organization.id', '=', 'capabilities.org_id');
        $queryPer->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $queryPer->leftJoin('status_mapping', 'status_mapping.id', '=', 'periods.status');
        $queryPer->leftJoin('likelihood_criteria', 'likelihood_criteria.period_id', '=', 'periods.id');
        $queryPer->leftJoin('risk_risk_matrix', 'risk_risk_matrix.period_id', '=', 'periods.id');
        if (isset($rq["search_name"]) && $rq["search_name"] != "" || isset($rq["search_name"]) && $rq["search_name"] != null) {
            $queryPer->whereRaw("(periods.name_periods LIKE '%" . $rq["search_name"] . "%')");
        }
        if (isset($request->status)) {
            $queryPer->where("periods.status", $request->status);
        }
        if (isset($request->type)) {
            $queryPer->where("periods.type", $type[$request->type]);
        }
        if ($user->org_id != 0) {
            $queryPer->where('organization.id', $user->org_id);
        }
        $queryPer->select('periods.id', 'periods.name_periods', 'organization.name_org', 'capabilities.name as name_capabilities', 'capabilities.id as id_capabilities', 'periods.type', 'periods.start_date as startdate', 'periods.end_date as enddate', 'periods.notes', 'capabilities.description', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text', 'likelihood_criteria.id as likelihood_id', 'risk_risk_matrix.id as risk_matrix_id');
        $queryPer->orderBy('periods.id', 'DESC');
        $period = $queryPer->paginate(20);
        $period_data = [];

        foreach ($period as $per_data) {
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Periods")->where("module_id", $per_data->id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            $period_data[] = [
                'id' => $per_data->id,
                'name_periods' => $per_data->name_periods,
                'name_org' => $per_data->name_org,
                'name_capabilities' => $per_data->name_capabilities,
                'id_capabilities' => $per_data->id_capabilities,
                'type' => $per_data->type,
                'startdate' => $per_data->startdate,
                'enddate' => $per_data->enddate,
                'notes' => $per_data->notes,
                'description' => $per_data->description,
                'likelihood_id' => $per_data->likelihood_id,
                'risk_matrix_id' => $per_data->personel_level,
                'status' => $per_data->status,
                'status_style' => $per_data->status_style,
                'status_text' => $per_data->status_text,
                'review_log' => $getReview,
                'review_log_count' => sizeof($getReview)
            ];
        }


        $audit_trails = Log::where('page', "Periods")->orderBy('created_at', 'asc')->get();

        $pagination = json_decode(json_encode($period));

        $toJsonStr = json_encode($period_data);
        $periods = json_decode($toJsonStr);
        $data_status_mapping = StatusMapping::select('id','status')->get();

        $organizations = Organization::leftJoin('periods', 'periods.org_id', 'organization.id')
            ->select('organization.id', 'organization.name_org')
            ->distinct()
            ->get();

        return view('pages.governance.periods.index', ['periods' => $periods, 'capabilities' => $capabilities, 'organization' => $organizations, 'access' => $access, 'audit_trails' => $audit_trails, 'pagination' => $pagination, 'status_mapping' => $data_status_mapping]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        $prds = Periods::where('name_periods', $request->name_periods)->first();

        if ($prds !== null) {
            return redirect('periods')->with('addperiodsfail', 'Nama Periods telah ada');

        }
        
        try {

            DB::beginTransaction();

            $insert = [
                'name_periods' => $request->name_periods,
                'org_id' => $user->org_id,
                'type' => $request->type,
                'start_date' => $request->startdate,
                'end_date' => $request->enddate,
                'id_capabilities' => $request->id_capabilities,
                'description' => $request->description,
                'status' => 1,
            ];

            $per_id = Periods::insertGetId($insert);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Periods", $request, $data, "CREATED");
            }

            Utility::log("Periods", $user, $per_id, $email, "CREATED");

            return redirect('periods')->with('addperiods', 'Data Periods berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('periods')->with('addperiodsfail', 'Data Periods gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        try {

            $organiz = capabilities::where('id', $request->id_capabilities)->first();
            DB::beginTransaction();

            $update = [
                'name_periods' => $request->name_periods,
                'org_id' => $organiz->org_id,
                'type' => $request->type,
                'id_capabilities' => $request->id_capabilities,
                'description' => $request->description,
                'status' => 3,
            ];

            Periods::where('id', $id)->update($update);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Periods", $request, $data, "RESUBMITTED");
            }


            Utility::log("Periods", $user, $id, $email, "RESUBMITTED");

            return redirect('periods')->with('update', 'Data periods berhasil diperbarui.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect('periods')->with('updatefail', 'Data periods gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        DB::table('periods')->where('id', $id)->delete();
        return redirect('periods')->with('delete', 'Data periods berhasil dihapus.');
    }

    public function approval(Request $request, $id)
    {
        $user = Auth::user();
        $periods = Periods::where('id', $id)->first();

        if(!isset($request->revnotes) || $request->revnotes == ''){
            return redirect('periods')->with('approveperiodsfail', 'Kolom Review Notes tidak boleh kosong.');
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
                        ->where('users.org_id', $periods->org_id)
                        ->where('roles.id', 2)
                        ->get();

                    $this->generateMatrix($request, $id, $periods->org_id);
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];

                foreach ($email as $data) {
                    Utility::notif("Periods", $request, $data, "APPROVED");
                }

                Utility::log("Periods", $user, $id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Periods", $id, $user, $request->revnotes, "Approved");
                }
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $periods->org_id)
                    ->where('roles.id', 2)
                    ->get();

                    
                    foreach ($email as $data) {
                        Utility::notif("Periods", $request, $data, "REJECTED");
                    }
                    
                    Utility::log("Periods", $user, $id, $email, "REJECTED");

                    if ($request->revnotes != "") {
                        $createReview = Utility::reviewLog("Periods", $id, $user, $request->revnotes, "Recheck");
                    }
            }
                
            Periods::where('id', $id)->update($update);

            DB::commit();

            return redirect('periods')->with('approveperiods', 'Data periods berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('periods')->with('approveperiodsfail', 'Data periods gagal diupdate.');
        }
    }

    protected function generateMatrix($req, $period_id, $org_id)
    {

        $checkMatrix = RiskMatrix::where("period_id", $period_id)->first();

        if (isset($checkMatrix->period_id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Risk Matrix dengan ID Period ini sudah ada!",
            ]);
        }
        try {

            $getPeriod = Periods::where("id", $period_id)->first();
            $user = Auth::user();

            if (isset($getPeriod->id)) {
                $dataMat = [
                    'period_id' => $getPeriod->id,
                    'status' => 1,
                ];

                $generateMat = RiskMatrix::create($dataMat);

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $org_id)
                    ->where('roles.id', 3)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Risk Matrix", $req, $data, "CREATED");
                }

                Utility::log("Risk Matrix", $user, $generateMat->id, $email, "CREATED");

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
        }
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        
        $user = Auth::user();

        $queryPer = Periods::query();
        $queryPer->leftJoin('capabilities', 'capabilities.id', '=', 'periods.id_capabilities');
        $queryPer->leftJoin('organization', 'organization.id', '=', 'capabilities.org_id');
        $queryPer->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $queryPer->leftJoin('status_mapping', 'status_mapping.id', '=', 'periods.status');
        $queryPer->leftJoin('likelihood_criteria', 'likelihood_criteria.period_id', '=', 'periods.id');
        $queryPer->leftJoin('risk_risk_matrix', 'risk_risk_matrix.period_id', '=', 'periods.id');

        if (isset($rq["search_name"]) && $rq["search_name"] != "" || isset($rq["search_name"]) && $rq["search_name"] != null) {
            $queryPer->whereRaw("(periods.name_periods LIKE '%" . $rq["search_name"] . "%')");
        }
        if (isset($request->status)) {
            $queryPer->where("periods.status", $request->status);
        }
        if ($user->org_id != 0) {
            $queryPer->where('organization.id', $user->org_id);
        }
        $queryPer->select('periods.id', 'periods.name_periods', 'organization.name_org', 'capabilities.name as name_capabilities', 'capabilities.id as id_capabilities', 'periods.type', 'periods.start_date as startdate', 'periods.end_date as enddate', 'periods.notes', 'capabilities.description', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text', 'likelihood_criteria.id as likelihood_id', 'risk_risk_matrix.id as risk_matrix_id');
        $period = $queryPer->get();
        $period_data = [];

        foreach ($period as $per_data) {
            $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Periods")->where("module_id", $per_data->id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            $period_data[] = [
                'id' => $per_data->id,
                'name_periods' => $per_data->name_periods,
                'name_org' => $per_data->name_org,
                'name_capabilities' => $per_data->name_capabilities,
                'id_capabilities' => $per_data->id_capabilities,
                'type' => $per_data->type,
                'startdate' => $per_data->startdate,
                'enddate' => $per_data->enddate,
                'notes' => $per_data->notes,
                'description' => $per_data->description,
                'likelihood_id' => $per_data->likelihood_id,
                'risk_matrix_id' => $per_data->personel_level,
                'status' => $per_data->status,
                'status_style' => $per_data->status_style,
                'status_text' => $per_data->status_text,
                'review_log' => $getReview,
                'review_log_count' => sizeof($getReview)
            ];
        }

        $toJsonStr = json_encode($period_data);
        $periods = json_decode($toJsonStr);

        return Excel::download(new GovernancesPeriods($periods), 'periods-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
