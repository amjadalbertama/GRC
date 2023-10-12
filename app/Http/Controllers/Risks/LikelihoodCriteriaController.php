<?php

namespace App\Http\Controllers\Risks;

use App\Exports\Risks\DetailsLikelihoodExp;
use App\Exports\Risks\LikelihoodExp;
use App\Models\Risks\{
    DetailLikelihood,
    LikelihoodCriteria
};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Library\Facades\Utility;
use App\Models\User;
use App\Models\Period_tes;
use \App\Library\GroupPermissions;
use App\Models\Governances\Periods;
use App\Models\Roles;
use App\Models\General\{
    StatusMapping,
    ReviewLogs as Review,
};
use Maatwebsite\Excel\Facades\Excel;

class LikelihoodCriteriaController extends Controller
{
    public function getView(GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();

        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add likelihoodcriteria'),
            'view' => $userdata->hasPermission('view likelihoodcriteria'),
            'update' => $userdata->hasPermission('update likelihoodcriteria'),
            'delete' => $userdata->hasPermission('delete likelihoodcriteria'),
            'approval' => $userdata->hasPermission('approval likelihoodcriteria'),
            'reviewer' => $userdata->hasPermission('reviewer likelihoodcriteria'),
        ];

        $query = LikelihoodCriteria::query();
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'likelihood_criteria.status');
        $query->leftJoin('organization', 'organization.id', '=', 'likelihood_criteria.org_id');
        $query->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $query->leftJoin('periods', 'periods.id', '=', 'likelihood_criteria.period_id');

        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }

        if (isset($request->status)) {
            $query->where("status_mapping.id", $request->status);
        }

        if (isset($request->type)) {
            $query->where("likelihood_criteria.type", $request->type);
        }

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(likelihood_criteria.name_periods LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'likelihood_criteria.id',
            'periods.name_periods',
            'periods.id as period_id',
            'periods.type',
            'status_mapping.status as status_likehood',
            'status_mapping.style',
            'status_mapping.text as status_text'
        );

        $likelihood = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $audit_trails = Log::where('page', "Likelihood Criteria")->orderBy('created_at', 'asc')->get();
        $data_status_mappings = StatusMapping::get();

        $data_type = [
            [
                "id" => 1,
                "type" => "Annual",
                "index_stat" => 0
            ],
            [
                "id" => 2,
                "type" => "Semester",
                "index_stat" => 1
            ],
            [
                "id" => 3,
                "type" => "Monthly",
                "index_stat" => 2
            ],
            [
                "id" => 4,
                "type" => "Quarterly",
                "index_stat" => 3
            ],
        ];
        return view('pages.risk.likelihood_criteria.index', [
            'likelihood_criteria' => $likelihood,
            'access' => $access,
            'audit_trails' => $audit_trails,
            'status_mapping' => $data_status_mappings,
            'type_mapping' => $data_type,
            'pagination' => json_decode(json_encode($likelihood)),
        ]);
    }

    public function details(GroupPermissions $userdata, $id)
    {
        $access = [
            'add' => $userdata->hasPermission('add likelihoodcriteria'),
            'view' => $userdata->hasPermission('view likelihoodcriteria'),
            'update' => $userdata->hasPermission('update likelihoodcriteria'),
            'delete' => $userdata->hasPermission('delete likelihoodcriteria'),
            'approval' => $userdata->hasPermission('approval likelihoodcriteria'),
            'reviewer' => $userdata->hasPermission('reviewer likelihoodcriteria'),
        ];

        $details = DetailLikelihood::leftJoin('likelihood_criteria', 'likelihood_criteria.id', '=', 'details_likelihood.likelihood_id')
            ->leftJoin('status_mapping', 'status_mapping.id', '=', 'likelihood_criteria.status')
            ->select(
                'likelihood_criteria.name_periods',
                'likelihood_criteria.id',
                'likelihood_criteria.notes',
                'likelihood_criteria.status as permission',
                'status_mapping.status',
                'status_mapping.style as status_style',
                'status_mapping.text as status_text',
                'details_likelihood.id as detail_id',
                'details_likelihood.likelihood_id',
                'details_likelihood.fnum_frequency',
                'details_likelihood.range_frequency',
                'details_likelihood.type_frequency',
                'details_likelihood.likelihood',
                'details_likelihood.range_start',
                'details_likelihood.range_end',
                'details_likelihood.name_level',
                'details_likelihood.score_level',
                'details_likelihood.code_warna'
            )->where('likelihood_id', $id)->paginate(20);
        $user = Auth::user();
        $role = User::where('id', $user->id)->get();

        $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Likelihood Criteria")->where("module_id", $id)->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get();

        $likelihood = LikelihoodCriteria::leftJoin('status_mapping', 'status_mapping.id', '=', 'likelihood_criteria.status')
            ->select('likelihood_criteria.id', 'likelihood_criteria.name_periods', 'likelihood_criteria.period_id', 'likelihood_criteria.type', 'status_mapping.status', 'status_mapping.style')
            ->paginate(20);

        return view('pages.risk.likelihood_criteria.likelihood', [
            'details_likelihood' => $details,
            'roles' => $role,
            'access' => $access,
            'likelihood_criteria' => $likelihood,
            'review' => $getReview,
        ]);
    }

    public function generateLikelihood(Request $request)
    {
        $user = Auth::user();
        // dd($user->org_id);
        $rq = $request->all();
        $checklikelihood = LikelihoodCriteria::where('period_id', $rq["likelihood"])->first();
        if (isset($checklikelihood->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Likelihood dengan ID Period ini sudah ada!",
            ]);
        }

        $getPeriods = Periods::where('id', $rq["likelihood"])->first();

        if (isset($getPeriods->id)) {
            $dataPeriod = [
                'name_periods' => $getPeriods->name_periods,
                'period_id' => $getPeriods->id,
                'type' => $getPeriods->type,
                'org_id' => $user->org_id,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $likelihood = LikelihoodCriteria::create($dataPeriod);
            $data_details = array(
                array(
                    "fnum_frequency" => '1-3',
                    "range_frequency" => 'in a couple',
                    "type_frequency" => 'of year',
                    "likelihood" => 'Very unlikely to occur',
                    "likelihood_id" => $likelihood->id,
                    "range_start" => 1,
                    "range_end" => 19,
                    "name_level" => 'Rare',
                    "score_level" => 1,
                    "code_warna" => '#b4c8eb',
                ),
                array(
                    "fnum_frequency" => '1-3',
                    "range_frequency" => 'within',
                    "type_frequency" => 'a year',
                    "likelihood" => 'Less likely to occur',
                    "likelihood_id" => $likelihood->id,
                    "range_start" => 20,
                    "range_end" => 39,
                    "name_level" => 'Unlikely',
                    "score_level" => 2,
                    "code_warna" => '#c6e6b1',
                ),
                array(
                    "fnum_frequency" => '1-3',
                    "range_frequency" => 'within',
                    "type_frequency" => 'a semester',
                    "likelihood" => 'May or may not accur',
                    "likelihood_id" => $likelihood->id,
                    "range_start" => 40,
                    "range_end" => 59,
                    "name_level" => 'Possible',
                    "score_level" => 3,
                    "code_warna" => '#ffffcc',
                ),
                array(
                    "fnum_frequency" => '1-3',
                    "range_frequency" => 'within',
                    "type_frequency" => 'a quarter',
                    "likelihood" => 'Most likely to occur',
                    "likelihood_id" => $likelihood->id,
                    "range_start" => 60,
                    "range_end" => 79,
                    "name_level" => 'Likely',
                    "score_level" => 4,
                    "code_warna" => '#ffefcc',
                ),
                array(
                    "fnum_frequency" => '1-3',
                    "range_frequency" => 'within',
                    "type_frequency" => 'a month',
                    "likelihood" => 'Almost certainly to occur',
                    "likelihood_id" => $likelihood->id,
                    "range_start" => 80,
                    "range_end" => 99,
                    "name_level" => 'Almost Certain',
                    "score_level" => 5,
                    "code_warna" => '#ffcccc',
                )
            );
            $new_insert_array = array();
            foreach ($data_details as $key => $data) {
                $new_insert_array[] = array(
                    'fnum_frequency' => $data['fnum_frequency'],
                    'range_frequency' => $data['range_frequency'],
                    'type_frequency' => $data['type_frequency'],
                    'likelihood' => $data['likelihood'],
                    'likelihood_id' => $data['likelihood_id'],
                    'range_start' => $data['range_start'],
                    'range_end' => $data['range_end'],
                    'name_level' => $data['name_level'],
                    'score_level' => $data['score_level'],
                    'code_warna' => $data['code_warna'],
                );
            }

            $res = DetailLikelihood::insert($new_insert_array);

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 3)
                ->get();
            $status = 'GENERATED';
            foreach ($email as $data) {
                Utility::notif("Likelihood Criteria", $request, $data, $status);
            }
            Utility::log("Likelihood Criteria", $user, $likelihood->id, $email, "GENERATED");

            return response()->json([
                "success" => true,
                "data" => $likelihood,
                "message" => "Data Likelihood berhasil di generate!",
            ]);
        } else {

            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Likelihood gagal di generate!",
            ]);
        }
    }


    public function add(Request $request, $id)
    {
        $obcat = DetailLikelihood::where(
            'likelihood',
            '$request->likelihood'
        )->first();
        if ($obcat !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Group telah ada',
            ]);
        }
        try {
            DB::beginTransaction();
            DetailLikelihood::create([
                'fnum_frequency' => $request->fnum_frequency,
                'range_frequency' => $request->range_frequency,
                'type_frequency' => $request->range_frequency,
                'likelihood' => $request->likelihood,
                'likelihood_id' => $request->likelihood_id,
                'range_start' => $request->range_start,
                'range_end' => $request->range_end,
                'name_level' => $request->name_level,
                'score_level' => $request->score_level,
                'code_warna' => $request->code_warna,
            ]);
            Auth::user();
            DB::commit();
            return redirect('detlikelihood')->with('add', 'Data Likelihood Criteria berhasil ditambahkan.');
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

    public function resubmitted(Request $request)
    {

        $user = Auth::user();
        DB::beginTransaction();
        $rq = $request->all();

        $getdetails = DetailLikelihood::where("id", $rq["detail_id"])->first();

        // dd($getdetails->id);
        if (isset($getdetails->id)) {
            $dataDetailLikelihood = [
                'fnum_frequency' => $rq["fnum_frequency"],
                'range_frequency' => $rq["range_frequency"],
                'type_frequency' => $rq["type_frequency"],
                'likelihood' => $rq["likehood"],
                'likelihood_id' => $rq["likeid"],
                'range_start' => $rq["range_start"],
                'range_end' => $rq["range_end"],
                'name_level' => $rq["name_level"],
                'score_level' => $rq["score_level"],
                'code_warna' => $rq["code_warna"],
            ];
            // dd($dataDetailLikelihood);
            $tes = DetailLikelihood::where("id", $getdetails->id)->update([$dataDetailLikelihood]);

            $status = [
                'status' => 3
            ];

            $likelihood = LikelihoodCriteria::where("id", $rq["likeid"])->update($status);

            Auth::user();

            // $email = User::join('roles', 'roles.id', '=', 'users.role_id')
            //     ->where('roles.id', 3)
            //     ->get();

            // foreach ($email as $data) {
            //     Utility::notif("Likelihood Criteria", $request, $data, $email);
            // }

            DB::commit();

            // Utility::log("Likelihood Criteria", $user, $getdetails->likelihood_id, $email, "RESUBMITTED");
            return response()->json([
                "success" => true,
                "data" => $likelihood,
                "message" => "Data Likelihood berhasil di Update",
            ]);

            // return redirect()->back()->with('update', 'Data Likelihood Criteria berhasil diupdate.');
        } else {
            return redirect()->back()->with('update', 'Data Likelihood Criteria berhasil diupdate.');
        }
    }

    public function update(Request $request, $detail_id)
    {
        $getcolorLikehood = DetailLikelihood::where('id', $detail_id)->first();
        try {
            $user = Auth::user();
            DB::beginTransaction();
            $update_detail = [
                'fnum_frequency' => $request->fnum_frequency,
                'range_frequency' => $request->range_frequency,
                'type_frequency' => $request->range_frequency,
                'likelihood' => $request->likelihood,
                'likelihood_id' => $request->likelihood_id,
                'range_start' => $request->range_start,
                'range_end' => $request->range_end,
                'name_level' => $request->name_level,
                'score_level' => $request->score_level,
                'code_warna' => $getcolorLikehood->code_warna,
            ];

            DetailLikelihood::where('id', $detail_id)->update($update_detail);

            $getPeriods = DetailLikelihood::where('id', $detail_id)->first();
            // $getLikelihood = Likelihood_criteria::where("id", $getPeriods->likelihood_id)->first();
            $update = [
                'status' => 3
            ];
            $tes = LikelihoodCriteria::where('id', $getPeriods->likelihood_id)->update($update);
            // dd($getLikelihood->status);
            $status = 'RESUBMITTED';
            Auth::user();
            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Likelihood Criteria", $request, $data, $status);
            }

            Utility::log("Likelihood Criteria", $user, $getPeriods->likelihood_id, $email, "RESUBMITTED");

            DB::commit();
            return redirect()->back()->with('update', 'Data Likelihood Criteria berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function delete($id)
    {
        DB::table('likelihood_criteria')->where('id', $id)->delete();
        return redirect('likelihood')->with('delete', 'Data Likelihood Criteria berhasil dihapus.');
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
                        ->where('roles.id', 2)
                        ->get();
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];
                $statusApp = 'APPROVED';
                foreach ($email as $data) {
                    Utility::notif("Likelihood Criteria", $request, $data, $statusApp);
                }

                Utility::log("Likelihood Criteria", $user, $id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    Utility::reviewLog("Likelihood Criteria", $id, $user, $request->revnotes, "Approved");
                }
                LikelihoodCriteria::where('id', $id)->update($update);

                DB::commit();

                return redirect()->back()->with('approve', 'Data Likelihood Criteria berhasil di Approve.');
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id', 2)
                    ->get();

                $App = 'RECHECK';
                foreach ($email as $data) {
                    Utility::notif("Likelihood Criteria", $request, $data, $App);
                }

                Utility::log("Likelihood Criteria", $user, $id, $email, "RECHECK");

                if ($request->revnotes != "") {
                    Utility::reviewLog("Likelihood Criteria", $id, $user, $request->revnotes, "Recheck");
                }

                LikelihoodCriteria::where('id', $id)->update($update);

                DB::commit();

                return redirect()->back()->with('recheck', 'Data Likelihood Criteria berhasil di Recheck.');
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

    public function getNotes($id)
    {
        $getKpi = DetailLikelihood::where("id", $id)->get()->toArray();

        if (sizeof($getKpi) != 0) {
            return response()->json([
                "success" => true,
                "data" => $getKpi,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getKpi,
                "message" => "Your data KPI is empty!",
            ]);
        }
    }

    public function exportData()
    {
        $query = LikelihoodCriteria::query();
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'likelihood_criteria.status');
        $query->leftJoin('organization', 'organization.id', '=', 'likelihood_criteria.org_id');
        $query->leftJoin('users', 'users.id', '=', 'organization.lead_role');
        $query->leftJoin('periods', 'periods.id', '=', 'likelihood_criteria.period_id');
        $query->select(
            'likelihood_criteria.id',
            'periods.name_periods',
            'periods.id as period_id',
            'periods.type',
            'status_mapping.status as status_likehood',
            'status_mapping.style',
            'status_mapping.text as status_text'
        );
        $likelihood = $query->orderBy("id", "ASC")->get();

        return Excel::download(new LikelihoodExp($likelihood), 'Likelihood-' . date("Y-m-d_H:i:s") . '.xlsx');
    }

    public function exportDataDetails($id)
    {
        $details = DetailLikelihood::leftJoin('likelihood_criteria', 'likelihood_criteria.id', '=', 'details_likelihood.likelihood_id')
            ->leftJoin('status_mapping', 'status_mapping.id', '=', 'likelihood_criteria.status')
            ->select(
                'details_likelihood.id as detail_id',
                'details_likelihood.likelihood_id',
                'details_likelihood.fnum_frequency',
                'details_likelihood.range_frequency',
                'details_likelihood.type_frequency',
                'details_likelihood.likelihood',
                'details_likelihood.range_start',
                'details_likelihood.range_end',
                'details_likelihood.name_level',
                'details_likelihood.score_level',
                'details_likelihood.code_warna'
            )->where('likelihood_id', $id)->get();
        // $likelihood = $query->orderBy("id", "ASC")->get();

        return Excel::download(new DetailsLikelihoodExp($details), 'Detail_Likelihood-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
