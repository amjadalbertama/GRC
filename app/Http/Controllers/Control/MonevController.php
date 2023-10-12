<?php

namespace App\Http\Controllers\Control;

use App\Exports\Controls\MonevExprt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    DB,
    Auth,
};
use App\Library\Facades\Utility;
use App\Models\Control\{
    Controls,
    ControlsActivity,
    Issue,
    Kci,
    Monev,
};
use App\Models\General\StatusMapping as Status;
use App\Models\Governances\{
    Kpi,
    Kpiperiod,
    Programs,
    ProgramsKsf as KSF,
    Strategies,
    Organization,
};
use App\Models\{
    Log,
    KpiObjective,
    Objectegory,
    Objective,
    RiskIdentification,
    User,
};
use App\Models\Risks\{
    Kri,
    RiskRegisterIdentifications as Identifications,
    RiskRegisters as RR,
};
use Maatwebsite\Excel\Facades\Excel;

class MonevController extends Controller
{
    public function getView(Request $request)
    {

        $rq = $request->all();

        $query = Objective::query();

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(objective.smart_objectives LIKE '%" . $rq["search_name"] . "%')");
        }

        $getMonev = $query->paginate(10)->toArray();

        $arrMonev = [];
        foreach ($getMonev["data"] as $key => $mn) {
            $data_objectegory = Objectegory::where("id", $mn["id_category"])->first();
            $data_organization = Organization::where("id", $mn["id_organization"])->first();

            $dataMonev = [
                'id' => $mn["id"],
                'smart_obj' => $mn["smart_objectives"],
                'status' => $mn["status"],
                'category' => isset($data_objectegory->title) ? $data_objectegory->title : "-",
                'organization' => $data_organization->name_org,
            ];

            array_push($arrMonev, $dataMonev);
        }

        $toJsonMon = json_encode($arrMonev);
        $monevs = json_decode($toJsonMon);

        return view('pages.control.monev.index', [
            'monev' => $monevs,
        ]);
    }

    public function detailsMonev($id)
    {
        $objective = Objective::where('id', $id)->first();

        return view('pages.control.monev.details_monev.details_monev', [
            'objective' => $objective,
        ]);
    }

    public function detailsIndicators($id)
    {
        $getKci = Kci::leftJoin('controls_activity', 'controls_activity.id', '=', 'kci.id_control_activity')
            ->leftJoin('controls', 'controls.id', "=", 'controls_activity.id_control')
            ->leftJoin('programs', 'programs.id', '=', 'controls.id_program')
            ->leftJoin('risk_registers', 'risk_registers.id', '=', 'programs.id_risk_register')
            ->leftJoin('objective', 'objective.id', '=', 'risk_registers.id_objective')
            ->select('kci.id as kci_id', 'kci.title as title_indi', 'kci.monitoring_status')
            ->where('objective.id', $id)->get()->toArray();
        $getKri = Kri::select('kri.id as kri_id', 'kri.kri as title_indi', 'kri.monitor_status as monitoring_status')
            ->where('obj_id', $id)->get()->toArray();
        $getKpi = Kpi::leftJoin('kpi_objective', 'kpi_objective.id_kpi', '=', 'kpi.id')
            ->leftJoin('objective', 'objective.id', '=', 'kpi_objective.id_objective')
            ->select('kpi.id as kpi_id', 'kpi.title as title_indi', 'kpi.monitoring_status')
            ->where('objective.id', $id)->get()->toArray();

        $dataIndicators = array_merge($getKci, $getKri, $getKpi);

        $indicators = [];
        foreach ($dataIndicators as $key => $indicator) {
            if (array_key_exists("kci_id", $indicator)) {
                $type = ["type" => "KCI",];
                $merge_kci = array_merge($indicator, $type);

                array_push($indicators, $merge_kci);
            } elseif (array_key_exists("kpi_id", $indicator)) {
                $type = ["type" => "KPI",];
                $merge_kpi = array_merge($indicator, $type);

                array_push($indicators, $merge_kpi);
            } elseif (array_key_exists("kri_id", $indicator)) {
                $type = ["type" => "KRI",];
                $merge_kri = array_merge($indicator, $type);

                array_push($indicators, $merge_kri);
            }
        }

        $objective = Objective::where('id', $id)->first();
        // Pass to view as Object from Array
        return view('pages.control.monev.details_monev.details_indicator_monev', [
            'indicators' => json_decode(json_encode($indicators)),
            'objective' => $objective
        ]);
    }

    public function detailsAchievement($id)
    {
        $getObj = json_decode(json_encode(Objective::where("id", $id)->first()), true);
        $getKpiObj = KpiObjective::where("id_objective", $id)->get()->toArray();

        if (sizeof($getKpiObj) != 0) {
            $achievements = [];
            foreach ($getKpiObj as $key => $kpiObj) {
                $getKpiPeriods["period"] = Kpiperiod::where("kpi_id", $kpiObj["id_kpi"])->get()->max()->toArray();

                $merged = array_merge($kpiObj, $getKpiPeriods);

                array_push($achievements, $merged);
            }

            $arrAchievement["achievements"] = $achievements;
            $mergeObj = array_merge($getObj, $arrAchievement);

            return response()->json([
                "success" => true,
                "data" => $mergeObj,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getKpiObj,
            ]);
        }
    }

    public function detailsStrategies($id)
    {
        $getStrtgy = Strategies::where('id_objective', $id)->get();
        $objective = Objective::where('id', $id)->first();
        return view('pages.control.monev.details_monev.details_strategy_monev', [
            'strategy' => $getStrtgy,
            'objective' => $objective,
        ]);
    }

    public function detailsControls($id)
    {
        $control = Controls::leftJoin('programs', 'programs.id', '=', 'controls.id_program')
            ->leftJoin('risk_registers', 'risk_registers.id', '=', 'programs.id_risk_register')
            ->leftJoin('objective', 'objective.id', '=', 'risk_registers.id_objective')
            ->leftJoin('status_mapping', 'status_mapping.id', '=', 'controls.status')
            ->where('controls.deleted_at', null)
            ->select('controls.id', 'controls.title', 'programs.id as id_program', 'programs.id_type', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
            ->where('objective.id', $id)
            ->get();

        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        foreach ($control as $data) {
            for ($i = 1; $i <= sizeof($listType); $i++) {
                if ($i == $data->id_type) {
                    $progtype = $listType[$i];
                }
            }
            $control_data[] = [
                "id" => $data->id,
                "title" => $data->title,
                "id_program" => $data->id_program,
                "program_type" => $progtype,
                "status" => $data->status,
                "status_style" => $data->status_style,
                "status_text" => $data->status_text
            ];
        }
        return view('pages.control.monev.details_monev.details_control', [
            'control' => $control_data,
        ]);
    }

    public function detailsStrategyPrograms($id, $id_obj)
    {
        $program = Programs::leftJoin('risk_registers', 'risk_registers.id', '=', 'programs.id_risk_register')
            ->leftJoin('strategies', 'strategies.id_risk_register', '=', 'risk_registers.id')
            ->select('strategies.title as title_strategy', 'programs.program_title', 'programs.id as id_program', 'programs.id_type', 'strategies.id as id_strategies')
            ->where('strategies.id', $id)
            ->get();

        $objective = Objective::where('id', $id_obj)->first();

        $listType = [
            "other",
            "Threat Mitigation",
            "Opportunity Expoitation",
            "Requirement Fulfillment",
        ];

        foreach ($program as $data) {
            for ($i = 1; $i <= sizeof($listType); $i++) {
                if ($i == $data->id_type) {
                    $progtype = $listType[$i];
                }
            }
            $program_data[] = [
                "title_strategy" => $data->title_strategy,
                "id_program" => $data->id_program,
                "program_type" => $progtype,
                "id_strategy" => $data->id_strategies,
                "program_title" => $data->program_title,
            ];
        }

        return view('pages.control.monev.details_monev.details_strategy_program', [
            'program' => $program_data,
            'objectives' => $objective,
        ]);
    }

    public function detailsStrgyPro($id)
    {
        $user = Auth::user();
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
            $getObjCat = json_decode(json_encode(Objectegory::where("id", $getObj["id_category"])->first()), true);
            $getStatus = json_decode(json_encode(Status::select("id as id_status", "status", "style", "text", "alert_style")->where("id", $dataPrograms["status"])->first()), true);
            $getControls = json_decode(json_encode(Controls::select("id as id_controls")->where("id_program", $id)->first()), true);
            $getProgKsf = KSF::where("id_program", $id)->get();

            $dataTreat["strategies"] = $getStrategy;
            $dataRiskIden["identification"] = $getRiskIden;
            $dataIden["identification"] = $getIden;

            $mergeRr = array_merge($getRr, $dataRiskIden, $dataTreat);
            $mergeObj = array_merge($getObj, $dataIden);

            for ($i = 1; $i <= sizeof($listType); $i++) {
                if ($i == $dataPrograms["id_type"]) {
                    $progtype = [
                        "id_type" => $i,
                        "type" => $listType[$i],
                    ];
                }
            }

            $programs = [
                "programs" => $dataPrograms,
                "programs_type" => $progtype,
                "programs_ksf" => $getProgKsf,
                "risk_register" => $mergeRr,
                "objective" => $mergeObj,
                "objective_category" => $getObjCat,
                "status" => $getStatus,
                "controls" => $getControls,
            ];

            if (isset($getObjCat["id"])) {
                return response()->json([
                    "success" => true,
                    "data" => $programs,
                    "message" => "",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Gagal mendapatkan detail Programs!",
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

    public function detailsMonControlsAct($id)
    {
        $ControlAct = ControlsActivity::leftJoin('status_mapping', 'status_mapping.id', '=', 'controls_activity.status')
            ->where('controls_activity.deleted_at', null)
            ->where('controls_activity.id_control', $id)
            ->select('controls_activity.id', 'controls_activity.activity_control', 'controls_activity.activity_type', 'controls_activity.activity_effectiveness', 'controls_activity.id_issue', 'status_mapping.status', 'status_mapping.style as status_style', 'status_mapping.text as status_text')
            ->get();

        $Controls = Controls::where('id', $id)
            ->first();

        return view('pages.control.monev.details_monev.details_control_activity_monev', ['controls' => $Controls, 'controls_act' => $ControlAct]);
    }

    public function exportData()
    {

        $query = Objective::query();
        $getMonev = $query
            ->orderBy("id", "ASC")
            ->get()
            ->toArray();
        $arrMonev = [];
        foreach ($getMonev as $key => $mn) {
            $data_objectegory = Objectegory::where("id", $mn["id_category"])->first();
            $data_organization = Organization::where("id", $mn["id_organization"])->first();

            $dataMonev = [
                'id' => $mn["id"],
                'smart_obj' => $mn["smart_objectives"],
                'status' => $mn["status"],
                'category' => isset($data_objectegory->title) ? $data_objectegory->title : "-",
                'organization' => $data_organization->name_org,
            ];

            array_push($arrMonev, $dataMonev);
        }

        $toJsonMon = json_encode($arrMonev);
        $monevs = json_decode($toJsonMon);

        return Excel::download(new MonevExprt($monevs), 'Monev-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
