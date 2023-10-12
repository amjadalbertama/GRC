<?php

namespace App\Http\Controllers\Risks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Risks\{
    RiskRegisters as RR,
    RiskRegisterAnalysis as Analysis,
    RiskRegisterEvaluations as Evaluation,
    RiskRegisterEvaluationAcceptReject as EvalAccRej,
    RiskRegisterIdentifications as Identifications,
    RiskRegisterMonitorings as Monitoring,
    RiskRegisterTreatments as Treatment,
    RiskRegisterTreatmentStrategy as Strategy,
    RiskRegisterStatusMapping as StatusRisk,
    Kri,
    ImpactCriteria,
};
use App\Models\{
    Objective,
    Objectegory,
    RiskIdentification,
    RiskAppetite,
    User,
};
use App\Models\Governances\{
    Strategies,
    Organization,
};
use App\Models\Control\{
    Issue,
};

class RegisterController extends Controller
{
    public function getRegister(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add risk_register'),
            'view' => $userdata->hasPermission('view risk_register'),
            'update' => $userdata->hasPermission('update risk_register'),
            'delete' => $userdata->hasPermission('delete risk_register'),
            'approval' => $userdata->hasPermission('approval risk_register'),
            'reviewer' => $userdata->hasPermission('reviewer risk_register'),
        ];

        $query = RR::query();

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $query->where("id_org", $user->org_id);
        }

        $getRr = $query->orderBy("id", "DESC")->paginate(10)->toArray();

        $data_rr = [];
        foreach ($getRr["data"] as $key => $rr) {
            $getOrg = Organization::where("id", $rr["id_org"])->first();
            $getObjCat = Objectegory::where("id", $rr["objective_category"])->first();
            $getStatusRisk = StatusRisk::where("status", $rr["status"])->first();

            $dataRr = [
                "id" => $rr["id"],
                "id_objective" => $rr["id_objective"],
                "id_risk_identification" => $rr["id_risk_identification"],
                "types" => $rr["types"],
                "status" => $getStatusRisk,
                "objective_category" => isset($getObjCat->title) ? $getObjCat->title : "-",
                "risk_event" => $rr["risk_event"],
                "id_org" => $rr["id_org"],
                "owner" => $rr["owner"],
                "additional_description" => $rr["additional_description"],
                "id_impact" => isset($rr["id_impact"]) ? $rr["id_impact"] : "-",
                "id_likelihood" => isset($rr["id_likelihood"]) ? $rr["id_likelihood"] : "-",
                "organization" => $getOrg,
                "created_at" => $rr["created_at"],
            ];
            array_push($data_rr, $dataRr);
        }

        $toJsonRr = json_encode($data_rr);
        $riskRegister = json_decode($toJsonRr);

        $getAllStatusRisks = StatusRisk::get();

        return view('pages.risk.risk_register.index')->with([
            "access" => $access,
            "risk_register" => $riskRegister,
            "status_mapping" => $getAllStatusRisks,
            'pagination' => json_decode(json_encode($getRr)),
        ]);
    }

    public function getRegisterEdit($id, \App\Library\GroupPermissions $userdata)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add risk_register'),
            'view' => $userdata->hasPermission('view risk_register'),
            'update' => $userdata->hasPermission('update risk_register'),
            'delete' => $userdata->hasPermission('delete risk_register'),
            'approval' => $userdata->hasPermission('approval risk_register'),
            'reviewer' => $userdata->hasPermission('reviewer risk_register'),
        ];

        $getRr = RR::where("id", $id)->first();
        $toJsonGetRr = json_encode($getRr);
        $rr = json_decode($toJsonGetRr, true);

        $getRiskRegIde = Identifications::where("id_risk_register", $id)->first();
        $getStatusRisk = StatusRisk::where("status", $rr["status"])->first();
        $getRiskRegAnal = Analysis::where("id_risk_register", $id)->first();
        $getEvaluation = Evaluation::where("id_risk_register", $id)->first();
        $getDataTreatment = Treatment::where("id_risk_register", $id)->first();
        $toJsonTreat = json_encode($getDataTreatment);
        $arrTreatment = json_decode($toJsonTreat, true);
        if (isset($getDataTreatment->id)) {
            $getTreatmentStrategy = Strategy::where("id_treatment", $getDataTreatment->id)->get();
        } else {
            $getTreatmentStrategy = [];
        }
        $getMonitor = Monitoring::where("id_risk_register", $id)->first();

        $getStatusRisks = StatusRisk::all();
        $getEvalAccRej = EvalAccRej::all();
        $getOrg = Organization::where("id", $rr["id_org"])->first();
        $getObj = Objective::where("id", $rr["id_objective"])->first();
        $getObjCatAll = Objectegory::where("status", "=", 5)->get();
        $getObjCat = Objectegory::where("id", $rr["objective_category"])->first();
        $getRiskIde = RiskIdentification::where("id", $rr["id_risk_identification"])->first();
        $getStrategy = Strategies::where("id_risk_register", $rr["id"])->first();
        $getKri = Kri::where("id_risk_register", $rr["id"])->first();
        $getIssueUpdate = Issue::where("id_risk_register", $rr["id"])->where("information_source", "=", 4)->first();
        $getIssueStatus = Issue::where("id_risk_register", $rr["id"])->where("information_source", "=", 5)->first();
        $getIssueAlarp = Issue::where("id_risk_register", $rr["id"])->where("information_source", "=", 6)->first();
        $getIssueKri = Issue::where("id_risk_register", $rr["id"])->where("information_source", "=", 9)->first();

        $dataTreatmentStrategy = [
            "programs" => $getTreatmentStrategy == null ? [] : $getTreatmentStrategy,
        ];
        $getTreatment = array_merge($arrTreatment == null ? [
            "is_monitoring" => 0,
            "risk_treatment_strategy" => "",
        ] : $arrTreatment, $dataTreatmentStrategy);

        $dataRr = [
            "id" => $rr["id"],
            "id_objective" => $rr["id_objective"],
            "id_risk_identification" => $rr["id_risk_identification"],
            "types" => $rr["types"],
            "status" => $getStatusRisk,
            "objective_category" => isset($getObjCat->title) ? $getObjCat->title : "-",
            "risk_event" => $rr["risk_event"],
            "id_org" => $rr["id_org"],
            "owner" => $rr["owner"],
            "additional_description" => $rr["additional_description"],
            "id_impact" => isset($rr["id_impact"]) ? $rr["id_impact"] : "-",
            "id_likelihood" => isset($rr["id_likelihood"]) ? $rr["id_likelihood"] : "-",
            "organization" => $getOrg,
            "objective" => $getObj,
            "risk_identification" => $getRiskIde,
            "identification" => $getRiskRegIde,
            "analysis" => $getRiskRegAnal,
            "evaluation" => $getEvaluation,
            "treatment" => $getTreatment,
            "monitoring" => $getMonitor,
            "strategies" => $getStrategy,
            "kri" => $getKri,
            "issues" => [
                "krim" => $getIssueKri,
                "update_change" => $getIssueUpdate,
                "tolerance_status" => $getIssueStatus,
                "tolerance_alarp" => $getIssueAlarp,
            ],
            "created_at" => $rr["created_at"],
        ];

        $toJsonRr = json_encode($dataRr);
        $riskRegister = json_decode($toJsonRr);

        return view('pages.risk.risk_register.edit')->with([
            "risk_register" => $riskRegister,
            "status_risk" => $getStatusRisks,
            "evaluation_accept_reject" => $getEvalAccRej,
            "objective_category" => $getObjCatAll,
        ]);
    }

    public function generateRisk(Request $request)
    {
        $rq = $request->all();

        $getAuth = Auth::user();

        //cek appetite
        $getAppetite = RiskAppetite::where("id_objective", $rq["id"])->first();

        if (!isset($getAppetite->id)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Risk Appetite belum di generate, generate terlebih dulu untuk melanjutkan generate Risk Register!",
            ]);
        }

        $getOwner = User::where("org_id", $getAuth->org_id)->where("role_id", 3)->first();

        $getObj = Objective::where("id", $rq["id"])->first();
        $getObjIde = RiskIdentification::where("id", $rq["idIde"])->first();
        $checkRisk = RR::where("id_objective", $rq['id'])->where("id_risk_identification", $rq["idIde"])->first();

        if (!isset($checkRisk->id)) {
            $dataInsRr = [
                'id_objective' => $getObj->id,
                'id_risk_identification' => $getObjIde->id,
                'types' => $getObjIde->type,
                'status' => "Active",
                'objective_category' => $getObj->id_category,
                'risk_event' => $getObjIde->risk_event,
                'id_org' => $getObj->id_organization,
                'owner' => $getOwner->name,
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $insRr = RR::create($dataInsRr);

            if (isset($insRr->id)) {
                $dataIde = [
                    "id_risk_register" => $insRr->id,
                    "risk_event_event" => $getObjIde->risk_event,
                    "risk_event_category" => $insRr->objective_category,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                $insIde = Identifications::create($dataIde);

                return response()->json([
                    "success" => true,
                    "data" => $insRr,
                    "message" => "Data Risk Register berhasil di generate!",
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Data Risk Register untuk ID Risk Identifications ini sudah ada!",
            ]);
        }
    }

    public function saveRegister(Request $request, $id)
    {
        $user = Auth::user();

        $message = [
            "krival1.required_if" => "Please input your KRI first!",
            "kritr11.required_if" => "KRI Lower field cannot be empty!",
            "kritr12.required_if" => "KRI Upper field cannot be empty!",
            "kri_parameter.required_if" => "KRI Parameter field cannot be empty!",
            "risk_impact_description.required" => "Field Impact Description is required, cannot be empty!",
            "risk_impact_areas.required" => "Field Areas is required, cannot be empty!",
            "irl.required" => "This field cannot be empty!",
            "irl_score.required" => "This field cannot be empty!",
            "iri.required" => "This field cannot be empty!",
            "iri_score.required" => "This field cannot be empty!",
            "exploits.required" => "Field Exploit is required, cannot be empty!",
            "preventive.required" => "Field Preventive is required, cannot be empty!",
            "eff_exp.required" => "You have to choose one Effectiveness from options!",
            "eff_pre.required" => "You have to choose one Effectiveness from options!",
            "kci_exp.required" => "This field cannot be empty, please fill this field!",
            "kci_pre.required" => "This field cannot be empty, please fill this field!",
            "crl.required" => "This field cannot be empty, please fill this field!",
            "crl_score.required" => "This field cannot be empty, please fill this field!",
            "cri.required" => "This field cannot be empty, please fill this field!",
            "cri_score.required" => "This field cannot be empty, please fill this field!",
            "benefit.required" => "Field Benefit is required, cannot be empty!",
            "accrej.required" => "Accept/Reject is required, you have to choose 1 from options!",
            "accrej.not_in" => "You have to choose Accept/Reject other than this from options!",
            "strategy.required_if" => "Field Strategy is required, cannot be empty!",
            "rrt_likelihood.required_if" => "This field is required, cannot be empty!",
            "rrt_likelihood_score.required_if" => "This field is required, cannot be empty!",
            "rrt_impact.required_if" => "This field is required, cannot be empty!",
            "rrt_impact_score.required_if" => "This field is required, cannot be empty!",
            "krim_status.required_if" => "You have to choose KRI Monitoring Status other than this from options!",
            "krim_status.not_in" => "You have to choose KRI Monitoring Status other than this from options!",
            "changes.required_if" => "You have to choose Update Changes other than this from options!",
            "changes.not_in" => "You have to choose Update Changes other than this from options!",
            "rra_likelihood.required_if" => "This field is required, cannot be empty!",
            "rra_likelihood_score.required_if" => "This field is required, cannot be empty!",
            "rra_impact.required_if" => "This field is required, cannot be empty!",
            "rra_impact_score.required_if" => "This field is required, cannot be empty!",
            "rtolerance.required_if" => "You have to choose Risk Tolerance Status is Tolerable or Not!",
            "rtolerance.not_in" => "You have to choose Risk Tolerance Status is Tolerable or Not!",
        ];

        $validator = Validator::make($request->all(), [
            "krival1" => "required_if:keyrisk,1",
            "kritr11" => "required_if:keyrisk,1",
            "kritr12" => "required_if:keyrisk,1",
            "kri_parameter" => "required_if:keyrisk,1",
            "risk_impact_description" => "required",
            "risk_impact_areas" => "required",
            "irl" => "required",
            "irl_score" => "required",
            "iri" => "required",
            "iri_score" => "required",
            "exploits" => Rule::requiredIf(function () use ($request) {
                return strtolower($request->type) == "opportunity";
            }),
            "preventive" => Rule::requiredIf(function () use ($request) {
                return strtolower($request->type) == "threat";
            }),
            "eff_exp" => Rule::requiredIf(function () use ($request) {
                return strtolower($request->type) == "opportunity";
            }),
            "eff_pre" => Rule::requiredIf(function () use ($request) {
                return strtolower($request->type) == "threat";
            }),
            "kci_exp" => Rule::requiredIf(function () use ($request) {
                return strtolower($request->type) == "opportunity";
            }),
            "kci_pre" => Rule::requiredIf(function () use ($request) {
                return strtolower($request->type) == "threat";
            }),
            "crl" => "required",
            "crl_score" => "required",
            "cri" => "required",
            "cri_score" => "required",
            "benefit" => "required",
            "accrej" => "required|not_in:null",
            "strategy" => "required_if:accrej,1",
            "rrt_likelihood" => "required_if:accrej,1",
            "rrt_likelihood_score" => "required_if:accrej,1",
            "rrt_impact" => "required_if:accrej,1",
            "rrt_impact_score" => "required_if:accrej,1",
            "krim_status" => "required_if:act_monitor,1|not_in:null",
            "changes" => "required_if:act_monitor,1|not_in:null",
            "rra_likelihood" => "required_if:act_monitor,1",
            "rra_likelihood_score" => "required_if:act_monitor,1",
            "rra_impact" => "required_if:act_monitor,1",
            "rra_impact_score" => "required_if:act_monitor,1",
            "rtolerance" => "required_if:act_monitor,1|not_in:null",
        ], $message)->validate();

        try {
            $dataRr = [
                "status" => $request->status,
                "additional_description" => $request->adddesc,
            ];

            $dataRegis = [
                "identification" => [
                    "id_risk_register" => $request->id_risk_regis,
                    "risk_event_event" => $request->revent,
                    "risk_event_category" => $request->category,
                    "risk_causes_internal" => $request->incause,
                    "risk_causes_external" => $request->excause,
                    "is_kri" => $request->keyrisk,
                    "kri" => $request->krival1,
                    "kri_lower" => $request->kritr11,
                    "kri_upper" => $request->kritr12,
                    "kri_parameter" => $request->kri_parameter,
                    "risk_impact_description" => $request->risk_impact_description,
                    "risk_impact_areas" => $request->risk_impact_areas,
                    'created_at' => date("Y-m-d H:i:s"),
                ],
                "analysis" => [
                    "id_risk_register" => $request->id_risk_regis,
                    "inherent_risk_likelihood" => $request->irl,
                    "inherent_risk_likelihood_score" => $request->irl_score,
                    "inherent_risk_impact" => $request->iri,
                    "inherent_risk_impact_score" => $request->iri_score,
                    "inherent_risk_score" => $request->irs_score,
                    "risk_existing_control_exploit" => $request->exploits,
                    "risk_existing_control_preventif" => $request->preventive,
                    "risk_existing_control_detective" => $request->detective,
                    "risk_existing_control_responsive" => $request->responsive,
                    "risk_existing_control_exploit_effectiveness" => $request->eff_exp,
                    "risk_existing_control_exploit_kci" => $request->kci_exp,
                    "risk_existing_control_preventif_effectiveness" => $request->eff_pre,
                    "risk_existing_control_preventif_kci" => $request->kci_pre,
                    "risk_existing_control_detective_effectiveness" => $request->eff_det,
                    "risk_existing_control_detective_kci" => $request->kci_det,
                    "risk_existing_control_responsive_effectiveness" => $request->eff_res,
                    "risk_existing_control_responsive_kci" => $request->kci_res,
                    "current_risk_likelihood" => $request->crl,
                    "current_risk_likelihood_score" => $request->crl_score,
                    "current_risk_impact" => $request->cri,
                    "current_risk_impact_score" => $request->cri_score,
                    "current_risk_score" => $request->crs_score,
                    'created_at' => date("Y-m-d H:i:s"),
                ],
                "evaluation" => [
                    "id_risk_register" => $request->id_risk_regis,
                    "risk_evaluation_level" => $request->rlevel,
                    "risk_evaluation_appetite" => $request->racceptance,
                    "risk_evaluation_benefit" => $request->benefit,
                    "risk_evaluation_accept_reject" => $request->accrej,
                    "risk_evaluation_priority" => $request->rpriority,
                    "capability" => $request->capability,
                    'created_at' => date("Y-m-d H:i:s"),
                ],
                "treatment" => [
                    "id_risk_register" => $request->id_risk_regis,
                    "risk_treatment_strategy" => $request->strategy,
                    "risk_treatment_residual_likelihood" => $request->rrt_likelihood,
                    "risk_treatment_residual_likelihood_score" => $request->rrt_likelihood_score,
                    "risk_treatment_residual_impact" => $request->rrt_impact,
                    "risk_treatment_residual_impact_score" => $request->rrt_impact_score,
                    "risk_treatment_residual_score" => $request->rrt_score,
                    "is_monitoring" => $request->act_monitor,
                    'created_at' => date("Y-m-d H:i:s"),
                ],
                "monitoring" => [
                    "id_risk_register" => $request->id_risk_regis,
                    "risk_monitoring_indicator" => $request->krim,
                    "risk_monitoring_lower" => $request->krim_lower,
                    "risk_monitoring_upper" => $request->krim_upper,
                    "risk_monitoring_status" => $request->krim_status,
                    "risk_tolerance_status" => $request->rtolerance,
                    "risk_tolerance_alarp" => $request->alarp,
                    "risk_update_changes" => $request->changes,
                    "risk_monitoring_actual_likelihood" => $request->rra_likelihood,
                    "risk_monitoring_actual_likelihood_score" => $request->rra_likelihood_score,
                    "risk_monitoring_actual_impact" => $request->rra_impact,
                    "risk_monitoring_actual_impact_score" => $request->rra_impact_score,
                    "risk_monitoring_actual_score" => $request->rra_score,
                    'created_at' => date("Y-m-d H:i:s"),
                ],
            ];
            $getRr = RR::where("id", $request->id_risk_regis)->first();
            $getRiskRegIde = Identifications::where("id_risk_register", $request->id_risk_regis)->first();
            $getRiskRegAnal = Analysis::where("id_risk_register", $request->id_risk_regis)->first();
            $getEvaluation = Evaluation::where("id_risk_register", $request->id_risk_regis)->first();
            $getTreatment = Treatment::where("id_risk_register", $request->id_risk_regis)->first();
            $getMonitor = Monitoring::where("id_risk_register", $request->id_risk_regis)->first();

            if (isset($getRr->id)) {
                $updRr = RR::where("id", $request->id_risk_regis)->update($dataRr);
            }

            if (!isset($getRiskRegIde->id_risk_register)) {
                $iden = Identifications::create($dataRegis["identification"]);
            } else {
                $iden = Identifications::where("id_risk_register", $request->id_risk_regis)->update($dataRegis["identification"]);
            }
            if (!isset($getRiskRegAnal->id_risk_register)) {
                $anal = Analysis::create($dataRegis["analysis"]);
            } else {
                $anal = Analysis::where("id_risk_register", $request->id_risk_regis)->update($dataRegis["analysis"]);
            }
            if (!isset($getEvaluation->id_risk_register)) {
                $eval = Evaluation::create($dataRegis["evaluation"]);
            } else {
                $eval = Evaluation::where("id_risk_register", $request->id_risk_regis)->update($dataRegis["evaluation"]);
            }

            if ($request->accrej == 1) {
                if (!isset($getTreatment->id_risk_register)) {
                    $treat = Treatment::create($dataRegis["treatment"]);
                } else {
                    $treat = Treatment::where("id_risk_register", $request->id_risk_regis)->update($dataRegis["treatment"]);
                }
                if (!isset($getMonitor->id_risk_register)) {
                    $monit = Monitoring::create($dataRegis["monitoring"]);
                } else {
                    $monit = Monitoring::where("id_risk_register", $request->id_risk_regis)->update($dataRegis["monitoring"]);
                }
            }

            // return response()->json([
            //     "success" => true,
            //     // "data" => $dataRegis,
            //     "message" => "Berhasil menambahkan/mengubah data!",
            // ]);
            return redirect('risk_register')->with('success', 'Berhasil menambahkan/mengubah data!');
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                // "data" => $dataRegis,
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function genTreatStrategy(Request $request, $id)
    {
        $getStrategies = Strategies::where("id", $id)->first();
        $getTreatment = Treatment::where("id_risk_register", $getStrategies->id_risk_register)->first();

        $dataTreatmentStrategy = [
            "id_risk_register" => $getStrategies->id_risk_register,
            "id_treatment" => isset($getTreatment->id) ? $getTreatment->id : null,
            "id_type" => $request->progtype,
            "program_title" => $request->program_title,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        try {
            $insTreatStrat = Strategy::create($dataTreatmentStrategy);

            if (isset($insTreatStrat->id)) {
                return response()->json([
                    "success" => true,
                    "data" => $insTreatStrat,
                    "message" => "Berhasil menambahkan Programs!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Gagal menambahkan Programs!",
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

    public function generateIssue(Request $request, $id)
    {
        $getRr = RR::where("id", $id)->first();

        if (!isset($request->title)) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Title / Notes is required!",
            ]);
        } elseif ($request->title == "" || $request->title == null) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Please input your Title / Notes first!",
            ]);
        }

        $dataIssue = [
            "id_risk_register" => $id,
            "title" => $request->title,
            "id_org" => $getRr->id_org,
            "followup_status" => 1,
            "type" => 1,
            "information_source" => $request->information_source,
            "created_at" => date("Y-m-d H:i:s"),
        ];

        try {
            $genIssue = Issue::create($dataIssue);

            if (isset($genIssue->id)) {
                return response()->json([
                    "success" => true,
                    "data" => $genIssue,
                    "message" => "Issue berhasil di generate!",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Issue Gagal di generate!",
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
}
