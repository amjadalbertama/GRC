<?php

namespace App\Http\Controllers\Governances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Library\Facades\Utility;

use App\Models\Governances\{
    Programs,
    ProgramsKsf as KSF,
    ProgramsLog as Log,
    Strategies,
};
use App\Models\Risks\{
    RiskRegisters as RR,
    RiskRegisterIdentifications as Identifications,
    RiskRegisterTreatments as Treatment,
};
use App\Models\General\{
    StatusMapping as Status,
    ReviewLogs as Review,
};
use App\Models\{
    Objective,
    Objectegory as Category,
    RiskIdentification,
    User,
};
use App\Models\Control\Controls;
use App\Exports\Governances\ProgramsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProgramsController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add programs'),
            'view' => $userdata->hasPermission('view programs'),
            'update' => $userdata->hasPermission('update programs'),
            'delete' => $userdata->hasPermission('delete programs'),
            'approval' => $userdata->hasPermission('approval programs'),
            'reviewer' => $userdata->hasPermission('reviewer programs'),
        ];

        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        $query = Programs::query();

        if (isset($request->search_data)) {
            $query->where("program_title", "LIKE", "%".$request->search_data."%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        // if ($user->org_id != 0) {
        //     $query->where("id_org", $user->org_id);
        // }

        $dataPrograms = $query->orderBy("id", "DESC")->paginate(10)->toArray();

        $arrProg = [];
        foreach ($dataPrograms["data"] as $key => $pr) {
            $getStrategy = json_decode(json_encode(Strategies::select("id as id_strategies")->where("id_risk_register", $pr["id_risk_register"])->first()), true);
            $getStatus = json_decode(json_encode(Status::select("id as id_status", "status", "style", "text")->where("id", $pr["status"])->first()), true);

            for ($i=1; $i <= sizeof($listType); $i++) {
                if ($i == $pr["id_type"]) {
                    $progtype = [
                        "id_type" => $i,
                        "type" => $listType[$i],
                    ];
                }
            }

            $dataStrategies = $getStrategy != null ? $getStrategy : ["id_strategies" => 0];
            
            $mergeProg = array_merge($pr, $dataStrategies, $getStatus, $progtype);
            array_push($arrProg, $mergeProg);
        }

        $toJsonProg = json_encode($arrProg);
        $programs = json_decode($toJsonProg);

        $getAllStatus = Status::get();

        return view('pages.governance.programs.index',  [
            'programs' => $programs,
            'access' => $access,
            'status_mapping' => $getAllStatus,
            'pagination' => json_decode(json_encode($dataPrograms)),
        ]);
    }

    public function detail(\App\Library\GroupPermissions $userdata, $id)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add programs'),
            'view' => $userdata->hasPermission('view programs'),
            'update' => $userdata->hasPermission('update programs'),
            'delete' => $userdata->hasPermission('delete programs'),
            'approval' => $userdata->hasPermission('approval programs'),
            'reviewer' => $userdata->hasPermission('reviewer programs'),
        ];

        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        try {
            $dataPrograms = json_decode(json_encode(Programs::where("id", $id)->first()), true);
            $getRr = json_decode(json_encode(RR::where("id", $dataPrograms["id_risk_register"])->first()), true);
            $getRiskIden = json_decode(json_encode(Identifications::where("id_risk_register", $getRr["id"])->first()), true);
            $getStrategy = json_decode(json_encode(Strategies::where("id_risk_register", $getRr["id"])->first()), true);
            $getIden = json_decode(json_encode(RiskIdentification::where("id_objective", $getRr["id_objective"])->where("id", $getRr["id_risk_identification"])->first()), true);
            $getObj = json_decode(json_encode(Objective::where("id", $getRr["id_objective"])->first()), true);
            $getObjCat = json_decode(json_encode(Category::where("id", $getObj["id_category"])->first()), true);
            $getStatus = json_decode(json_encode(Status::select("id as id_status", "status", "style", "text", "alert_style")->where("id", $dataPrograms["status"])->first()), true);
            $getControls = json_decode(json_encode(Controls::select("id as id_controls")->where("id_program", $id)->first()), true);
            $getProgKsf = KSF::where("id_program", $id)->get();
            $getReview["notes"] = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Programs")->where("module_id", $dataPrograms["id"])->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            $dataTreat["strategies"] = $getStrategy;
            $dataRiskIden["identification"] = $getRiskIden;
            $dataIden["identification"] = $getIden;

            $mergeRr = array_merge($getRr, $dataRiskIden, $dataTreat);
            $mergeObj = array_merge($getObj, $dataIden);

            for ($i=1; $i <= sizeof($listType); $i++) {
                if ($i == $dataPrograms["id_type"]) {
                    $progtype = [
                        "id_type" => $i,
                        "type" => $listType[$i],
                    ];
                }
            }

            $mergeProg = array_merge($dataPrograms, $getReview);

            $programs = [
                "programs" => $mergeProg,
                "programs_type" => $progtype,
                "programs_ksf" => $getProgKsf,
                "risk_register" => $mergeRr,
                "objective" => $mergeObj,
                "objective_category" => isset($getObjCat->title) ? $getObjCat : ["id" => 0, "title" => "-"],
                "status" => $getStatus,
                "controls" => $getControls,
            ];

            if (isset($getObjCat["id"])) {
                return response()->json([
                    "success" => true,
                    "data" => $programs,
                    "access" => $access,
                    "message" => "",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "access" => $access,
                    "message" => "Gagal mendapatkan detail Programs!",
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "access" => $access,
                "message" => $e->getMessage(),
            ]);
        }
        
    }

    public function add(Request $request)
    {
        DB::table('programs')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'owner' => $request->owner,
            'date' => $request->date,
            'name_org' => $request->name_org,
            'status' => $request->status,
        ]);

        return redirect('programs')->with('addorg', 'Data programs  berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $capcheck = json_decode($request->capability_checklist, true);
        $arrCapCheck = [];
        for ($i=1; $i <= 4; $i++) { 
            if (!in_array($i, $capcheck)) {
                $mesCapCheck = [
                    "capability_checklist-".$i => "is-invalid",
                    "capability_checklist_validation-".$i => "Please check it first!",
                ];
                array_push($arrCapCheck, $mesCapCheck);
            }
        }

        $cekKsf = KSF::where("id_program", $id)->count();

        $messages = [
            "program_title.required" => "This field is required, please fill first!",
            "actions.required" => "This field is required, please fill first!",
            "schedule.required" => "This field is required, please fill first!",
            "control_act.required" => "This field is required, please fill first!",
        ];

        $validator = Validator::make($request->all(), [
            "program_title" => "required",
            "actions" => "required",
            "schedule" => "required",
            "control_act" => "required",
        ], $messages);

        if ($validator->fails() || $cekKsf == 0 || sizeof($arrCapCheck) != 0) {
            return response()->json([
                "data_validation" => $validator->errors(),
                "capability_checklist" => $arrCapCheck,
                "total_ksf" => $cekKsf,
            ], 422);
        }

        $dataReqProg = [
            'program_title' => $request->program_title,
            'actions' => $request->actions,
            'id_type' => $request->progtype,
            'budget' => $request->budget == 'NaN' ? 0 : $request->budget,
            'output' => $request->output,
            'capability_checklist' => $request->capability_checklist,
            'cba_ratio' => $request->cba_ratio,
            'schedule' => date("Y-m-d", strtotime($request->schedule)),
            'pic' => $request->pic,
            'status' => 3,
            'id_type_controls' => $request->id_type_controls,
            'controls' => $request->control_act,
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        try {
            $updProg = Programs::where('id', $id)->update($dataReqProg);

            if ($updProg == 1) {
                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                foreach ($email as $data) {
                    Utility::notif("Programs", $request, $data, "RESUBMITTED");
                }

                Utility::log("Programs", $user, $id, $email, "RESUBMITTED");

                return response()->json([
                    "success" => $updProg,
                    "data" => [
                        "status" => 3,
                    ],
                    "message" => "Programs berhasil disimpan!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Programs gagal disimpan",
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

    public function delete($id)
    {
        Programs::where('id', $id)->delete();
        return redirect('programs')->with('delete', 'Data programs berhasil dihapus.');
    }

    public function generatePrograms(Request $request)
    {
        $reqBodyProg = [
            'id_risk_register' => $request->id_risk_register,
            'program_title' => $request->program_title,
            'id_type' => $request->progtype,
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        try {
            $insProg = Programs::create($reqBodyProg);

            if (isset($insProg->id)) {
                return response()->json([
                    "success" => true,
                    "data" => $insProg,
                    "message" => "Programs berhasil di-generate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Programs gagal di-generate",
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

    public function getKsf($id)
    {
        $user = Auth::user();

        $getProgKsf = KSF::where("id", $id)->first();

        if (isset($getProgKsf->id)) {
            return response()->json([
                "success" => true,
                "data" => $getProgKsf,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getProgKsf,
                "message" => "Data KSF tidak ada",
            ]);
        }
    }

    public function editKsf(Request $request, $id)
    {
        $user = Auth::user();

        $getProgKsf = KSF::where("id", $id)->first();

        if (isset($getProgKsf->id)) {
            // $logKsf = [
            //     "id_program" => $getProgKsf->id_program,
            //     "data_deleted" => json_encode($getProgKsf),
            //     "deleted_by" => $user->name,
            //     "created_at" => date("Y-m-d H:i:s"),
            // ];
            // $insLogProg = Log::create($logKsf);

            $updKsf = KSF::where("id", $id)->update([
                "ksf_title" => $request->ksf_title,
            ]);

            if ($updKsf == 1) {
                $getKsfProg = KSF::where("id", $id)->first();

                return response()->json([
                    "success" => true,
                    "data" => $getKsfProg,
                    "message" => "Berhasil mengubah KSF",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => $getProgKsf,
                    "message" => "Gagal mengubah KSF",
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KSF tidak ada",
            ]);
        }
    }

    public function addKsf(Request $request)
    {
        $dataReqKsf = [
            "id_program" => $request->id_program,
            "ksf_title" => $request->ksf_title,
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $insKsf = KSF::create($dataReqKsf);

        if (isset($insKsf->id)) {
            return response()->json([
                "success" => true,
                "data" => $insKsf,
                "message" => "Berhasil menambahkan KSF",
            ]);
        } else {
            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "Gagal menambahkan KSF",
            ]);
        }
    }

    public function delKsf(Request $request, $id)
    {
        $user = Auth::user();

        $getProgKsf = KSF::where("id", $id)->first();

        if (isset($getProgKsf->id)) {
            $logKsf = [
                "id_program" => $getProgKsf->id_program,
                "reasons" => $request->reasons,
                "data_deleted" => json_encode($getProgKsf),
                "deleted_by" => $user->name,
                "created_at" => date("Y-m-d H:i:s"),
            ];
            $insLogProg = Log::create($logKsf);

            if (isset($insLogProg->id)) {
                $delKsf = KSF::where("id", $id)->delete();

                if ($delKsf == 1) {
                    return response()->json([
                        "success" => true,
                        "data" => $delKsf,
                        "message" => "Berhasil menghapus KSF",
                    ]);
                } else {
                    return response()->json([
                        "success" => false,
                        "data" => [],
                        "message" => "Gagal menghapus KSF",
                    ]);
                }
            } else {
                return response()->json([
                    "success" => true,
                    "data" => [],
                    "message" => "Gagal membuat Log",
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data KSF tidak ada",
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
                    'status' => $status,
                ];

                $updProg = Programs::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Programs", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Programs", $request, $data, "APPROVED");
                }

                Utility::log("Programs", $user, $id, $email, "APPROVED");
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                $updProg = Programs::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Programs", $id, $user, $request->revnotes, "Recheck");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Programs", $request, $data, "REJECTED");
                }

                Utility::log("Programs", $user, $id, $email, "REJECTED");
            }

            if ($updProg == 1) {
                return response()->json([
                    "success" => true,
                    "data" => $updProg,
                    "message" => "Approval / Recheck is success!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => $updProg,
                    "message" => "Approval / Recheck has failed!",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "data" => $e->getMessage(),
                "message" => "Approval / Recheck has failed!",
            ]);
        }
    }

    public function exportData(Request $request)
    {
        $user = Auth::user();

        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        $query = Programs::query();

        if (isset($request->search_data)) {
            $query->where("program_title", "LIKE", "%".$request->search_data."%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        // if ($user->org_id != 0) {
        //     $query->where("id_org", $user->org_id);
        // }

        $dataPrograms = $query->get()->toArray();

        $arrProg = [];
        foreach ($dataPrograms as $key => $pr) {
            $getStrategy = json_decode(json_encode(Strategies::select("id as id_strategies")->where("id_risk_register", $pr["id_risk_register"])->first()), true);
            $getStatus = json_decode(json_encode(Status::select("id as id_status", "status", "style", "text")->where("id", $pr["status"])->first()), true);

            for ($i=1; $i <= sizeof($listType); $i++) {
                if ($i == $pr["id_type"]) {
                    $progtype = [
                        "id_type" => $i,
                        "type" => $listType[$i],
                    ];
                }
            }

            $dataStrategies = $getStrategy != null ? $getStrategy : ["id_strategies" => 0];
            
            $mergeProg = array_merge($pr, $dataStrategies, $getStatus, $progtype);
            array_push($arrProg, $mergeProg);
        }

        $toJsonProg = json_encode($arrProg);
        $programs = json_decode($toJsonProg);

        return Excel::download(new ProgramsExport($programs), 'programs-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
