<?php

namespace App\Http\Controllers\Risks;

use App\Exports\Risk\ImpactCriteria as RiskImpactCriteria;
use App\Http\Controllers\Controller;
use App\Library\Facades\Utility;
use App\Models\Log;
use App\Models\Objective;
use App\Models\RiskAppetite;
use App\Models\Risks\ImpactCriteria;
use App\Models\Risks\ImpactCriteriaArea;
use App\Models\Risks\ImpactCriteriaLevel;
use App\Models\RiskThreshold;
use App\Models\User;
use App\Models\General\{
    ReviewLogs as Review,
    StatusMapping,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImpactCriteriaController extends Controller
{
    public function getImpactCriteria(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add impactcriteria'),
            'view' => $userdata->hasPermission('view impactcriteria'),
            'update' => $userdata->hasPermission('update impactcriteria'),
            'delete' => $userdata->hasPermission('delete impactcriteria'),
            'approval' => $userdata->hasPermission('approval impactcriteria'),
            'reviewer' => $userdata->hasPermission('reviewer impactcriteria'),
        ];

        $query = ImpactCriteria::query();
        $query->leftJoin('objective', 'objective.id', '=', 'risk_impact_criteria.obj_id');
        $query->leftJoin('periods', 'periods.id', '=', 'objective.id_period');
        $query->leftJoin('capabilities', 'capabilities.id', '=', 'periods.id_capabilities');
        $query->leftJoin('organization', 'organization.id', '=', 'objective.id_organization');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'risk_impact_criteria.status');
        if (isset($request->status)) {
            $query->where("risk_impact_criteria.status", $request->status);
        }
        if (isset($request->search_data)) {
            $query->where("objective.smart_objectives", "LIKE", "%" . $request->search_data . "%");
        }
        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }
        $query->select('risk_impact_criteria.id', 'objective.smart_objectives', 'risk_impact_criteria.area_count', 'organization.name_org', 'capabilities.name as cap_name', 'periods.name_periods', 'risk_impact_criteria.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $impact = $query
            ->orderBy("id", "DESC")
            ->paginate(10);

        $audit_trails = Log::where('page', "Impact Criteria")->orderBy('created_at', 'asc')->get();
        $impact_area = ImpactCriteriaArea::get();
        $data_status_mapping = StatusMapping::select('id','status')->get();

        return view('pages.risk.impact_criteria.index', ['impact_criteria' => $impact, 'impact_area' => $impact_area, 'access' => $access, 'audit_trails' => $audit_trails, 'status_mapping' => $data_status_mapping]);
    }

    public function getImpactCriteriaDetail(\App\Library\GroupPermissions $userdata, $id)
    {

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add impactcriteria'),
            'view' => $userdata->hasPermission('view impactcriteria'),
            'update' => $userdata->hasPermission('update impactcriteria'),
            'delete' => $userdata->hasPermission('delete impactcriteria'),
            'approval' => $userdata->hasPermission('approval impactcriteria'),
            'reviewer' => $userdata->hasPermission('reviewer impactcriteria'),
        ];
        $query = ImpactCriteria::query();
        $query->leftJoin('objective', 'objective.id', '=', 'risk_impact_criteria.obj_id');
        $query->leftJoin('periods', 'periods.id', '=', 'objective.id_period');
        $query->leftJoin('capabilities', 'capabilities.id', '=', 'periods.id_capabilities');
        $query->leftJoin('organization', 'organization.id', '=', 'objective.id_organization');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'risk_impact_criteria.status');
        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }
        $query->where('risk_impact_criteria.id', $id);
        $query->select('risk_impact_criteria.id', 'objective.id as id_objective', 'objective.smart_objectives', 'risk_impact_criteria.area_count', 'organization.name_org', 'capabilities.name as cap_name', 'periods.name_periods', 'risk_impact_criteria.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $impact = $query->first();

        $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Impact Criteria")->where("module_id", $id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();
        $reviewLog['review_log'] = $getReview;
        $reviewLog['review_log_count'] = sizeof($getReview);

        $impact_level = ImpactCriteriaLevel::where('impact_id', $id)->get()->toArray();
        $impact_area = ImpactCriteriaArea::where('impact_id', $id)->get();
        $impact_area_name = $impact_area->collect()->groupBy('impact_area');
        $audit_trails = Log::where('page', "Impact Criteria")->orderBy('created_at', 'asc')->get();

        return view('pages.risk.impact_criteria.details', ['impact_criteria' => $impact, 'impact_area' => $impact_area_name, 'impact_level' => $impact_level, 'access' => $access, 'audit_trails' => $audit_trails, 'review_logs' => $reviewLog]);
    }

    public function generateIC(Request $request)
    {
        $rq = $request->all();

        $checkImpact = ImpactCriteria::where("risk_app_id", $rq["risk_app_id"])->first();

        if (isset($checkImpact->risk_app_id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Impact Criteria dengan ID Risk Appetite ini sudah ada!",
            ]);
        }
        try {

            DB::beginTransaction();

            $getRiskApp = RiskAppetite::where("id", $rq["risk_app_id"])->first();
            $getRiskTres = RiskThreshold::where("id_risk_appetite", $rq['risk_app_id'])->get();
            $user = Auth::user();

            if (isset($getRiskApp->id)) {
                $dataImp = [
                    'area_count' => 0,
                    'risk_app_id' => $getRiskApp->id,
                    'obj_id' => $getRiskApp->id_objective,
                    'status' => 1,
                ];

                $generateImp = ImpactCriteria::create($dataImp);
                $i = 1;
                foreach ($getRiskTres as $risk) {
                    $new_insert_array[] = array(
                        'impact_id' => $generateImp->id,
                        'impact_level' => $risk->status,
                        'impact_value' => $i,
                        'impact_level_color' => $risk->color,
                    );
                    $i++;
                }
                ImpactCriteriaLevel::insert($new_insert_array);

                DB::commit();

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 3)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Impact Criteria", $request, $data, "CREATED");
                }

                Utility::log("Impact Criteria", $user, $generateImp->id, $email, "CREATED");

                return response()->json([
                    "success" => true,
                    "data" => $generateImp,
                    "message" => "Data Impact Criteria berhasil di generate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Impact Criteria gagal di generate!",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function addImpactCriteriaDetail(Request $request)
    {
        $user = Auth::user();
        $rq = $request->all();
        $impact_criteria_id = $rq["impact_criteria_id"];
        $impact_area = $rq["impact_area"];
        $criteria_type = $rq["criteria_type"];
        unset($rq["impact_criteria_id"]);
        unset($rq["impact_area"]);
        unset($rq["criteria_type"]);
        unset($rq["_token"]);

        $data = array_chunk($rq, 6, true);
        $check_impact = ImpactCriteriaArea::where('impact_id', $impact_criteria_id)->where("impact_area", $impact_area)->first();
        $check_impact_level = ImpactCriteriaLevel::where("impact_id", $impact_criteria_id)->get();

        if (isset($check_impact->impact_area)) {
            return redirect("/impactdetail/" . $impact_criteria_id)->with('impactcriteriafail', 'Data Impact Criteria Area ini sudah ada!');
        }

        try {

            DB::beginTransaction();

            $array_data = [];
            for ($i = 0; $i < 5; $i++) {
                $array = [];
                $array['impact_level'] = $check_impact_level[$i]->id;
                foreach ($data[$i] as $index => $value) {
                    $array[substr($index, 0, -3)] = $value;
                }
                array_push($array_data, $array);
            }


            foreach ($array_data as $data_build) {
                if ($criteria_type == 'Percentage Range') {
                    $insert_data[] = [
                        "impact_id" => $impact_criteria_id,
                        "impact_area" => $impact_area,
                        "impact_level" => $data_build['impact_level'],
                        "impact_area_value_min" => $data_build['value_min'],
                        "impact_area_value_max" => $data_build['value_max'],
                        "impact_area_value_symbols" => $data_build['symbols'],
                        "impact_area_description" => $data_build['desc'],
                        "impact_area_type" => $criteria_type,
                    ];
                } elseif ($criteria_type == 'Comply/Not Comply') {
                    if ($data_build['comply'] == 'Comply') {
                        $value_min = 100;
                        $value_max = 100;
                    } elseif ($data_build['comply'] == 'Not Comply') {
                        $value_min = 0;
                        $value_max = 99;
                    } else {
                        $value_min = null;
                        $value_max = null;
                    }
                    $insert_data[] = [
                        "impact_id" => $impact_criteria_id,
                        "impact_area" => $impact_area,
                        "impact_level" => $data_build['impact_level'],
                        "impact_area_value_min" => $value_min,
                        "impact_area_value_max" => $value_max,
                        "impact_area_value_symbols" => "",
                        "impact_area_description" => $data_build['comply'],
                        "impact_area_type" => $criteria_type,
                    ];
                } elseif ($criteria_type == 'Text-based') {
                    $insert_data[] = [
                        "impact_id" => $impact_criteria_id,
                        "impact_area" => $impact_area,
                        "impact_level" => $data_build['impact_level'],
                        "impact_area_value_min" => 0,
                        "impact_area_value_max" => 0,
                        "impact_area_value_symbols" => "",
                        "impact_area_description" => $data_build['text'],
                        "impact_area_type" => $criteria_type,
                    ];
                }
            }

            $insert_area = ImpactCriteriaArea::insert($insert_data);

            DB::commit();

            $impact_area = ImpactCriteriaArea::where('impact_id', $impact_criteria_id)->get();

            $impact_area_name = $impact_area->collect()->groupBy('impact_area');

            $updateCount = ImpactCriteria::where('id', $impact_criteria_id)->update([
                "area_count" => sizeof($impact_area_name)
            ]);

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Impact Criteria Area", $request, $data, "CREATED");
            }

            Utility::log("Impact Criteria", $user, $impact_criteria_id, $email, "CREATED");

            return redirect("/impactdetail/" . $impact_criteria_id)->with('impactcriteria', 'Data Impact Criteria Area berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect("/impactdetail/" . $impact_criteria_id)->with('impactcriteriafail', 'Data Impact Criteria Area gagal ditambahkan.');
        }
    }

    public function editImpactCriteriaDetail(Request $request)
    {
        $user = Auth::user();
        $rq = $request->all();

        $impact_criteria_id = $rq["impact_criteria_id"];
        $impact_area = $rq["impact_area"];
        $impact_area_old = $rq["impact_area_old"];
        $criteria_type = $rq["criteria_type"];
        unset($rq["impact_criteria_id"]);
        unset($rq["impact_area"]);
        unset($rq["impact_area_old"]);
        unset($rq["criteria_type"]);
        unset($rq["_token"]);

        $data = array_chunk($rq, 6, true);
        $check_impact = ImpactCriteriaArea::where("impact_area", $impact_area_old)->first();
        $check_impact_level = ImpactCriteriaLevel::where("impact_id", $impact_criteria_id)->get();

        try {
            DB::beginTransaction();

            if (isset($check_impact->impact_area)) {
                ImpactCriteriaArea::where("impact_id", $impact_criteria_id)->where('impact_area', $impact_area_old)->delete();
            }


            $array_data = [];
            for ($i = 0; $i < 5; $i++) {
                $array = [];
                $array['impact_level'] = $check_impact_level[$i]->id;
                foreach ($data[$i] as $index => $value) {
                    $array[substr($index, 0, -3)] = $value;
                }
                array_push($array_data, $array);
            }


            foreach ($array_data as $data_build) {
                if ($criteria_type == 'Percentage Range') {
                    $insert_data[] = [
                        "impact_id" => $impact_criteria_id,
                        "impact_area" => $impact_area,
                        "impact_level" => $data_build['impact_level'],
                        "impact_area_value_min" => $data_build['value_min'],
                        "impact_area_value_max" => $data_build['value_max'],
                        "impact_area_value_symbols" => $data_build['symbols'],
                        "impact_area_description" => $data_build['desc'],
                        "impact_area_type" => $criteria_type,
                    ];
                } elseif ($criteria_type == 'Comply/Not Comply') {
                    if ($data_build['comply'] == 'Comply') {
                        $value_min = 100;
                        $value_max = 100;
                    } elseif ($data_build['comply'] == 'Not Comply') {
                        $value_min = 0;
                        $value_max = 99;
                    } else {
                        $value_min = null;
                        $value_max = null;
                    }
                    $insert_data[] = [
                        "impact_id" => $impact_criteria_id,
                        "impact_area" => $impact_area,
                        "impact_level" => $data_build['impact_level'],
                        "impact_area_value_min" => $value_min,
                        "impact_area_value_max" => $value_max,
                        "impact_area_value_symbols" => "",
                        "impact_area_description" => $data_build['comply'],
                        "impact_area_type" => $criteria_type,
                    ];
                } elseif ($criteria_type == 'Text-based') {
                    $insert_data[] = [
                        "impact_id" => $impact_criteria_id,
                        "impact_area" => $impact_area,
                        "impact_level" => $data_build['impact_level'],
                        "impact_area_value_min" => 0,
                        "impact_area_value_max" => 0,
                        "impact_area_value_symbols" => "",
                        "impact_area_description" => $data_build['text'],
                        "impact_area_type" => $criteria_type,
                    ];
                }
            }

            $insert_area = ImpactCriteriaArea::insert($insert_data);

            DB::commit();

            $impact_area = ImpactCriteriaArea::where('impact_id', $impact_criteria_id)->get();

            $impact_area_name = $impact_area->collect()->groupBy('impact_area');

            $updateCount = ImpactCriteria::where('id', $impact_criteria_id)->update([
                "area_count" => sizeof($impact_area_name),
                "status" => 3
            ]);


            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Impact Criteria Area", $request, $data, "RESUBMITTED");
            }

            Utility::log("Impact Criteria", $user, $impact_criteria_id, $email, "RESUBMITTED");

            return redirect("/impactdetail/" . $impact_criteria_id)->with('impactcriteria', 'Data Impact Criteria Area berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect("/impactdetail/" . $impact_criteria_id)->with('impactcriteriafail', 'Data Impact Criteria Area gagal ditambahkan.');
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
        if(!isset($request->revnotes) || $request->revnotes == ''){
            return redirect("/impactdetail/" . $id)->with('impactcriteriafail', 'Review Notes tidak boleh kosong!');
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
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];


                foreach ($email as $data) {
                    Utility::notif("Impact Criteria", $request, $data, "APPROVED");
                }

                Utility::log("Impact Criteria", $user, $id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Impact Criteria", $id, $user, $request->revnotes, "Approved");
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
                    Utility::notif("Impact Criteria", $request, $data, "REJECTED");
                }
                
                Utility::log("Impact Criteria", $user, $id, $email, "REJECTED");

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Impact Criteria", $id, $user, $request->revnotes, "Recheck");
                }            
            }
            
            ImpactCriteria::where('id', $id)->update($update);

            DB::commit();

            return redirect("/impactdetail/" . $id)->with('impactcriteria', 'Data Impact Criteria berhasil diapprove.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect("/impactdetail/" . $id)->with('impactcriteriafail', 'Data Impact Criteria gagal diapprove.');
        }
    }

    public function delImpact($id)
    {
        $getImpactCriteria = ImpactCriteria::where("id", $id)->first();

        if (isset($getImpactCriteria->id)) {
            $delImpactAreaDetail = ImpactCriteriaArea::where("impact_id", $getImpactCriteria->id)->delete();
            $delImpactLevel = ImpactCriteriaLevel::where("impact_id", $getImpactCriteria->id)->delete();
            $delImpactCriteria = ImpactCriteria::where("id", $id)->delete();

            return redirect("impactria")->with('impactcriteria', 'Data Impact Criteria berhasil dihapus.');
        } else {
            return redirect("impactria")->with('failapprove', 'Data Impact Criteria tidak ada!');
        }
        
    }

    public function exportData(Request $request)
    {
        
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        
        $user = Auth::user();

        $query = ImpactCriteria::query();
        $query->leftJoin('objective', 'objective.id', '=', 'risk_impact_criteria.obj_id');
        $query->leftJoin('periods', 'periods.id', '=', 'objective.id_period');
        $query->leftJoin('capabilities', 'capabilities.id', '=', 'periods.id_capabilities');
        $query->leftJoin('organization', 'organization.id', '=', 'objective.id_organization');
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'risk_impact_criteria.status');
        if (isset($request->status)) {
            $query->where("risk_impact_criteria.status", $request->status);
        }
        if (isset($request->search_data)) {
            $query->where("objective.smart_objectives", "LIKE", "%" . $request->search_data . "%");
        }
        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }
        $query->select('risk_impact_criteria.id', 'objective.smart_objectives', 'risk_impact_criteria.area_count', 'organization.name_org', 'capabilities.name as cap_name', 'periods.name_periods', 'risk_impact_criteria.notes', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text');
        $impact = $query->get();

        return Excel::download(new RiskImpactCriteria($impact), 'impact_criteria-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
