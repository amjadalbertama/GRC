<?php

namespace App\Http\Controllers\Risks;

use App\Exports\Risk\RiskMatrix as RiskRiskMatrix;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\Likelihood_criteria;
use App\Models\Log;
use App\Models\Risks\ImpactCriteria;
use App\Models\Risks\ImpactCriteriaArea;
use App\Models\Risks\RiskMatrix;
use App\Models\Risks\RiskMatrixSetting;
use App\Models\User;
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RiskMatrixController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add risk_matrix'),
            'view' => $userdata->hasPermission('view risk_matrix'),
            'update' => $userdata->hasPermission('update risk_matrix'),
            'delete' => $userdata->hasPermission('delete risk_matrix'),
            'approval' => $userdata->hasPermission('approval risk_matrix'),
            'reviewer' => $userdata->hasPermission('reviewer risk_matrix'),
        ];
        $type = [
            1 => 'Annual',
            2 => 'Semester',
            3 => 'Quarterly',
            4 => 'Monthly'
        ];
        $query = RiskMatrix::leftJoin('periods', 'periods.id', '=', 'risk_risk_matrix.period_id');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'risk_risk_matrix.status');

        if (isset($request->status)) {
            $query->where("risk_risk_matrix.status", $request->status);
        }

        if (isset($request->search_data)) {
            $query->where("periods.name_periods", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->type)) {
            $query->where("periods.type", $type[$request->type]);
        }

        if ($user->org_id != 0) {
            $query->where('periods.org_id', $user->org_id);
        }

        $query->select('risk_risk_matrix.id', 'periods.id as period_id', 'periods.name_periods', 'periods.type as period_type', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');

        $matrix = $query->orderBy('id', 'DESC')
        ->get();

        $audit_trails = Log::where('page', "Impact Criteria")->orderBy('created_at', 'asc')->get();
        $data_status_mapping = StatusMapping::select('id','status')->get();

        return view('pages.risk.risk_matrix.index', ['risk_matrix' => $matrix, 'access' => $access, 'audit_trails' => $audit_trails, 'status_mapping' => $data_status_mapping]);
    }

    public function getViewSetting(\App\Library\GroupPermissions $userdata, $id)
    {

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add risk_matrix'),
            'view' => $userdata->hasPermission('view risk_matrix'),
            'update' => $userdata->hasPermission('update risk_matrix'),
            'delete' => $userdata->hasPermission('delete risk_matrix'),
            'approval' => $userdata->hasPermission('approval risk_matrix'),
            'reviewer' => $userdata->hasPermission('reviewer risk_matrix'),
        ];

        if ($user->org_id != 0) {
            $matrix = RiskMatrix::select('risk_risk_matrix.*', 'periods.org_id', 'risk_risk_matrix_settings.likelihood_scale', 'risk_risk_matrix_settings.likelihood_scale_threshold', 'risk_risk_matrix_settings.likelihood_scale_tolerance')->leftJoin('risk_risk_matrix_settings', 'risk_risk_matrix_settings.risk_matrix_id', '=', 'risk_risk_matrix.id')
                ->leftJoin('periods', 'periods.id', '=', 'risk_risk_matrix.period_id')
                ->where('periods.org_id', $user->org_id)
                ->where('risk_risk_matrix.id', $id)
                ->first();
        } else {
            $matrix = RiskMatrix::select('risk_risk_matrix.*', 'risk_risk_matrix_settings.likelihood_scale', 'risk_risk_matrix_settings.likelihood_scale_threshold', 'risk_risk_matrix_settings.likelihood_scale_tolerance')->leftJoin('risk_risk_matrix_settings', 'risk_risk_matrix_settings.risk_matrix_id', '=', 'risk_risk_matrix.id')
                ->leftJoin('periods', 'periods.id', '=', 'risk_risk_matrix.period_id')
                ->where('risk_risk_matrix.id', $id)
                ->first();
        }
        $matrix['likelihood_scale'] = json_decode($matrix['likelihood_scale']);
        $threshold_line = $matrix['likelihood_scale_threshold'];
        $tolerance_line = $matrix['likelihood_scale_tolerance'];

        $likelihood = Likelihood_criteria::leftJoin('details_likelihood', 'details_likelihood.likelihood_id', '=', 'likelihood_criteria.id')
            ->where('period_id', $matrix->period_id)
            ->orderBy('details_likelihood.score_level', 'desc')
            ->get();
        if (count($likelihood) == 0) {
            session()->flash('error', 'Mohon generate likelihood terlebih dahulu pada menu periods');
            return redirect("/risk_matrix/")->with('error', 'mohon generate likelihood terlebih dahulu pada menu periods');
        }

        $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Risk Matrix")->where("module_id", $id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();
        $reviewLog['review_log'] = $getReview;
        $reviewLog['review_log_count'] = sizeof($getReview);

        $audit_trails = Log::where('page', "Impact Criteria")->orderBy('created_at', 'asc')->get();

        return view('pages.risk.risk_matrix.settings', ['risk_matrix' => $matrix, 'threshold_line' => $threshold_line, 'tolerance_line' => $tolerance_line, 'access' => $access, 'audit_trails' => $audit_trails, 'periods' => $matrix->period_id, 'likelihood' => $likelihood, 'user' => $user, 'review_logs' => $reviewLog]);
    }

    public function saveRiskMatrix(Request $request, $id)
    {
        $user = Auth::user();
        $rq = $request->all();


        $period_id = $rq["period_id"];

        unset($rq["period_id"]);

        $data_req = array_chunk($rq, 5, true);

        $check_matrix = RiskMatrix::where('period_id', $period_id)->first();
        $check_matrix_setting = RiskMatrixSetting::where("risk_matrix_id", $check_matrix->id)->first();
        try {

            DB::beginTransaction();

            $array_data = [];
            for ($i = 0; $i < 5; $i++) {
                $array = [];
                foreach ($data_req[$i] as $index => $value) {
                    switch ($value) {
                        case 1:
                            $color = 'bg-greenish';
                            break;
                        case 2:
                            $color = 'bg-yellowish';
                            break;
                        case 3:
                            $color = 'bg-orangish';
                            break;
                        case 4:
                            $color = 'bg-reddish';
                            break;
                    }
                    $array[$index] = $value . '_' . $color;
                }
                array_push($array_data, $array);
            }

            $insert_data = [
                "risk_matrix_id" => $check_matrix->id,
                "likelihood_scale" => json_encode($array_data)
            ];

            if (isset($check_matrix_setting->risk_matrix_id)) {
                if ($check_matrix->status == 2) {
                    RiskMatrix::where('period_id', $period_id)->update([
                        'status' => 3
                    ]);
                }
                $insert_area = RiskMatrixSetting::where('id', $check_matrix_setting->risk_matrix_id)->update($insert_data);
            } else {
                $insert_area = RiskMatrixSetting::insert($insert_data);
            }

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Risk Matrix Setting", $request, $data, "CREATED");
            }

            Utility::log("Risk Matrix", $user, $check_matrix->id, $email, "CREATED");

            return response()->json([
                "code" => 200,
                "success" => true,
                "message" => 'Success save Risk Matrix Setting'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "code" => 200,
                "success" => false,
                "message" => 'Fail save Risk Matrix Setting'
            ]);
        }
    }

    public function saveRiskMatrixThresholdLine(Request $request, $id)
    {
        $user = Auth::user();
        $rq = $request->all();
        $threshold_line = $rq["threshold_line"];

        $check_matrix = RiskMatrix::where('period_id', $id)->first();

        try {
            DB::beginTransaction();
            if ($check_matrix->status == 2) {
                RiskMatrix::where('period_id', $id)->update([
                    'status' => 3
                ]);
            }
            RiskMatrixSetting::where('risk_matrix_id', $check_matrix->id)->update([
                "likelihood_scale_threshold" => $threshold_line,
            ]);
            DB::commit();
            return response()->json([
                "code" => 200,
                "success" => true,
                "message" => "success save Threshold Line"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "code" => 200,
                "success" => false,
                "message" => "fail save Threshold Line"
            ]);
        }
    }

    public function saveRiskMatrixToleranceLine(Request $request, $id)
    {
        $user = Auth::user();
        $rq = $request->all();
        $tolerance_line = $rq["tolerance_line"];

        $check_matrix = RiskMatrix::where('period_id', $id)->first();

        try {
            DB::beginTransaction();
            if ($check_matrix->status == 2) {
                RiskMatrix::where('period_id', $id)->update([
                    'status' => 3
                ]);
            }
            RiskMatrixSetting::where('risk_matrix_id', $check_matrix->id)->update([
                "likelihood_scale_tolerance" => $tolerance_line,
            ]);
            DB::commit();
            return response()->json([
                "code" => 200,
                "success" => true,
                "message" => "success save Tolerance Line"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "code" => 200,
                "success" => false,
                "message" => "fail save Tolerance Line"
            ]);
        }
    }

    public function delImpactAreaDetail(Request $request)
    {
        $rq = $request->all();

        ImpactCriteriaArea::where('impact_area', $rq['impact_area'])->delete();

        $impact_area = ImpactCriteriaArea::where('impact_id', $rq['impact_criteria_id'])->get();
        $impact_area_name = $impact_area->collect()->groupBy('impact_area');

        $updateCount = ImpactCriteria::where('id', $rq['impact_criteria_id'])->update([
            "area_count" => sizeof($impact_area_name)
        ]);

        return redirect("/impactdetail/" . $rq['impact_criteria_id'])->with('delimpactarea', 'Data Impact Criteria Area berhasil dihapus.');
    }

    public function approveImpactCriteria(Request $request, $id)
    {
        $user = Auth::user();
        $periods = ImpactCriteria::where('id', $id)->first();

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
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];

                ImpactCriteria::where('id', $id)->update($update);

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Impact Criteria", $request, $data, "APPROVED");
                }

                Utility::log("Impact Criteria", $user, $id, $email, "APPROVED");
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $periods->org_id)
                    ->where('roles.id', 2)
                    ->get();

                ImpactCriteria::where('id', $id)->update($update);

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Impact Criteria", $request, $data, "REJECTED");
                }

                Utility::log("Impact Criteria", $user, $id, $email, "REJECTED");
            }

            return redirect("/impactdetail/" . $id)->with('approve', 'Data Impact Criteria berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect("/impactdetail/" . $id)->with('approve', 'Data Impact Criteria gagal diupdate.');
        }
    }


    public function approveRiskMatrix(Request $request, $id)
    {
        $user = Auth::user();
        $riskMatrix = RiskMatrix::where('period_id', $id)->first();

        if(!isset($request->revnotes) || $request->revnotes == ''){
            return response()->json([
                "code" => 200,
                "success" => false,
                "message" => 'Review Notes tidak boleh kosong!'
            ]);
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
                        ->where('users.org_id', $riskMatrix->org_id)
                        ->where('roles.id', 2)
                        ->get();
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];

                foreach ($email as $data) {
                    Utility::notif("Risk Matrix", $request, $data, "APPROVED");
                }

                Utility::log("Risk Matrix", $user, $riskMatrix->id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Risk Matrix", $riskMatrix->id, $user, $request->revnotes, "Approved");
                }
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $riskMatrix->org_id)
                    ->where('roles.id', 2)
                    ->get();

                    
                foreach ($email as $data) {
                    Utility::notif("Risk Matrix", $request, $data, "REJECTED");
                }
                
                Utility::log("Risk Matrix", $user, $riskMatrix->id, $email, "REJECTED");
                
                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Risk Matrix", $riskMatrix->id, $user, $request->revnotes, "Recheck");
                }
            }
            
            RiskMatrix::where('id', $riskMatrix->id)->update($update);

            DB::commit();

            return response()->json([
                "code" => 200,
                "success" => true,
                "message" => 'Data Risk Matrix berhasil diupdate.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "code" => 200,
                "success" => false,
                "message" => 'Data Risk Matrix gagal diupdate.'
            ]);
        }
    }

    public function exportData(Request $request)
    {
        
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        
        $user = Auth::user();

        $query = RiskMatrix::leftJoin('periods', 'periods.id', '=', 'risk_risk_matrix.period_id');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'risk_risk_matrix.status');

        if (isset($request->status)) {
            $query->where("risk_risk_matrix.status", $request->status);
        }

        if (isset($request->search_data)) {
            $query->where("periods.name_periods", "LIKE", "%" . $request->search_data . "%");
        }

        if ($user->org_id != 0) {
            $query->where('periods.org_id', $user->org_id);
        }

        $query->select('risk_risk_matrix.id', 'periods.id as period_id', 'periods.name_periods', 'periods.type as period_type', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');

        $matrix = $query->get();

        return Excel::download(new RiskRiskMatrix($matrix), 'risk_matrix-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
