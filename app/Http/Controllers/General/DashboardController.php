<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Auth,
};

use App\Models\{
    Log,
    KpiObjective,
    Objectegory,
    Objective,
    RiskIdentification,
    Roles,
    User,
};
use App\Models\Governances\{
    Organization,
    Kpi,
    Kpiperiod,
};
use App\Models\Control\{
    Kci,
};
use App\Models\Risks\{
    Kri,
    RiskRegisters,
    RiskRegisterAnalysis as Analysis,
    RiskRegisterTreatments as Treat
};

use App\Models\Compliance\{
    ComplianceRegister,
    TypeStatusFulfilled
};
use Psy\Readline\Hoa\Console;
use App\Library\BarCharts\MetaDashboard;


class DashboardController extends Controller
{
    public function index_dashboard()
    {
        return view('pages.general.dashboard.index');
    }
    public function index_governance()
    {
        return view('pages.general.governance.index');
    }
    public function index_achievement()
    {
        $getObjAch = Objective::where('status', 5)->get();

        $dataArch = [];
        foreach ($getObjAch as $j => $kl) {

            $getObcatAch = Objectegory::where("id", $kl["id_category"])->get();
            $getObjKpi = KpiObjective::where("id_objective", $kl["id"])->get();

            foreach ($getObcatAch as $r => $gt) {

                foreach ($getObjKpi as $h => $kp) {
                    $getKpiPeriods = Kpiperiod::select('score')->where('kpi_id', $kp['id_kpi'])->get()->max();

                    if ($getKpiPeriods['score'] <= 90) {
                        $colorBar = 'danger';
                        $width = $getKpiPeriods['score'];
                    } elseif ($getKpiPeriods['score']  > 90 && $getKpiPeriods['score']  <= 95) {
                        $colorBar = 'warning';
                        $width = $getKpiPeriods['score'];
                    } elseif ($getKpiPeriods['score']  > 95 && $getKpiPeriods['score']  <= 100) {
                        $colorBar = 'success';
                        $width = $getKpiPeriods['score'];
                    } elseif ($getKpiPeriods['score']  > 100) {
                        $colorBar = 'primary';
                        $width = 100;
                    }

                    $periodColor = [
                        "id" => $kl['id'],
                        "category" => $gt['id'],
                        "title" => $kp['kpi'],
                        "score" => $getKpiPeriods['score'],
                        "color" => $colorBar,
                        "width" => $width
                    ];

                    array_push($dataArch, $periodColor);
                }
            }
        }

        $toJsonAchiev = json_encode($dataArch);
        $achievement = json_decode($toJsonAchiev);

        $getCate = Objectegory::get();


        return view('pages.general.achievements.index', [
            'achieve' => $achievement,
            'catecieve' => $getCate,
        ]);
    }
    public function index_key_indicator()
    {
        return view('pages.general.key_indicators.index');
    }
    public function index_obligation()
    {
        return view('pages.general.obligations.index');
    }
    public function index_risks()
    {
        return view('pages.general.risks.index');
    }
    public function home()
    {
        return view('home.index');
    }

    public function getObjective(Request $request)
    {
        $getObj = Objective::whereYear("created_at", $request->period)->get()->toArray();
        $getCountObjAchieved = $this->getCountObjAchieved($request->period, true);
        $getCountObjNotAchieved = $this->getCountObjNotAchieved($request->period, false);

        $dataObj = [];
        foreach ($getObj as $key => $obj) {
            $getCate["category"] = json_decode(json_encode(Objectegory::where("id", $obj["id_category"])->first()), true);
            $getOrg["organization"] = json_decode(json_encode(Organization::where("id", $obj["id_organization"])->first()), true);

            $mergeObj = array_merge($obj, $getCate, $getOrg);
            array_push($dataObj, $mergeObj);
        }

        $dataCountAchievement = [
            $getCountObjAchieved,
            $getCountObjNotAchieved,
        ];

        if (sizeof($getObj) != 0) {
            return response()->json([
                "success" => true,
                "data" => $dataObj,
                "meta" => [
                    "achievements" => $dataCountAchievement,
                ],
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $dataObj,
                "meta" => [
                    "achievements" => $dataCountAchievement,
                ],
                "message" => "Your data Objective is empty!",
            ]);
        }
    }

    public function getObligations(Request $request)
    {
        $getObligat = ComplianceRegister::whereYear("created_at", $request->period)->get()->toArray();

        $dataDashObligat = [];
        foreach ($getObligat as $key => $obligat) {
            $getOrg = Organization::where("id", $obligat["organization"])->first();
            $getStatus = TypeStatusFulfilled::where('id', $obligat["fulfillment_status"])->first();


            $dataObligat = [
                "id" => $obligat["id"],
                "compliance" => $obligat["compliance"],
                "organization" => $getOrg->name_org,
                "status" => ($getStatus == null || $getStatus == "") ? "" : $getStatus->name_status,
                "status_style" => ($getStatus == null || $getStatus == "") ? "" : $getStatus->style_status,
            ];
            array_push($dataDashObligat, $dataObligat);
        }

        $getStatusNotff = ComplianceRegister::select('fulfillment_status')->where('fulfillment_status', 1)->whereYear("created_at", $request->period)->get()->count();
        $getStatusOnProff = ComplianceRegister::select('fulfillment_status')->where('fulfillment_status', 2)->whereYear("created_at", $request->period)->get()->count();
        $getStatusPartff = ComplianceRegister::select('fulfillment_status')->where('fulfillment_status', 3)->whereYear("created_at", $request->period)->get()->count();
        $getStatusFullff = ComplianceRegister::select('fulfillment_status')->where('fulfillment_status', 4)->whereYear("created_at", $request->period)->get()->count();

        if (sizeof($getObligat) != 0) {
            return response()->json([
                "success" => true,
                "data" => $dataDashObligat,
                "statnotff" => $getStatusNotff,
                "statonproff" => $getStatusOnProff,
                "statpartff" => $getStatusPartff,
                "statfullff" => $getStatusFullff,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $dataDashObligat,
                "statnotff" => $getStatusNotff,
                "statonproff" => $getStatusOnProff,
                "statpartff" => $getStatusPartff,
                "statfullff" => $getStatusFullff,
                "message" => "Your data Compliance is empty!",
            ]);
        }
    }


    public function getCountObjAchieved($period, $achievement)
    {
        $getCountObjAchieved = Objective::select("achievement")->whereYear("created_at", $period)->where("achievement", $achievement)->get()->count();

        return $getCountObjAchieved;
    }

    public function getCountObjNotAchieved($period, $achievement)
    {
        $getCountObjNotAchieved = Objective::select("achievement")->whereYear("created_at", $period)->where("achievement", $achievement)->get()->count();

        return $getCountObjNotAchieved;
    }

    public function getObjectiveAchievement(Request $request)
    {
        $getObjCat = Objectegory::whereYear("created_at", $request->period)->get()->toArray();

        $metaLabel = [];
        $dataCountAchievement = [];
        $dataTotalAchievement = [];
        $i = 0;
        foreach ($getObjCat as $key => $cate) {
            $getCountObjAchievedByCateId = $this->getCountObjAchievedByCateId($request->period, true, $cate["id"]);
            $getCountObjTotalByCateId = $this->getCountObjTotalByCateId($request->period, $cate["id"]);

            array_push($metaLabel, $cate["title"]);
            array_push($dataCountAchievement, $getCountObjAchievedByCateId);
            array_push($dataTotalAchievement, $getCountObjTotalByCateId);
            $i++;
        }

        $dataObj = [
            "meta_label" => $metaLabel,
            "achievements" => $dataCountAchievement,
            "total" => $dataTotalAchievement,
        ];

        if (sizeof($getObjCat) != 0) {
            return response()->json([
                "success" => true,
                "data" => $dataObj,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $dataObj,
                "message" => "Your data Objective is empty!",
            ]);
        }
    }

    public function getCountObjAchievedByCateId($period, $achievement, $id_category)
    {
        $getCountObjAchievedByCateId = Objective::select("achievement")->whereYear("created_at", $period)->where("achievement", $achievement)->where("id_category", $id_category)->get()->count();

        return $getCountObjAchievedByCateId;
    }

    public function getCountObjTotalByCateId($period, $id_category)
    {
        $getCountObjTotalByCateId = Objective::whereYear("created_at", $period)->where("id_category", $id_category)->get()->count();

        return $getCountObjTotalByCateId;
    }

    public function getListKpi(Request $request)
    {
        $getKpi = Kpi::whereYear("created_at", $request->period)->get()->toArray();

        $dataMetaKpi = (new MetaDashboard($getKpi))->getMetaDashboard();

        if (sizeof($getKpi) != 0) {
            return response()->json([
                "success" => true,
                "data" => array_slice($getKpi, 0, 5),
                "meta" => [
                    "data" => $dataMetaKpi,
                ],
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getKpi,
                "meta" => [
                    "data" => $dataMetaKpi,
                ],
                "message" => "Your data KPI is empty!",
            ]);
        }
    }

    public function getListKci(Request $request)
    {
        $getKci = Kci::whereYear("created_at", $request->period)->get()->toArray();

        $dataMetaKci = (new MetaDashboard($getKci))->getMetaDashboard();

        if (sizeof($getKci) != 0) {
            return response()->json([
                "success" => true,
                "data" => array_slice($getKci, 0, 5),
                "meta" => [
                    "data" => $dataMetaKci,
                ],
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getKci,
                "meta" => [
                    "data" => $dataMetaKci,
                ],
                "message" => "Your data KCI is empty!",
            ]);
        }
    }

    public function getListKri(Request $request)
    {
        $getKri = Kri::whereYear("created_at", $request->period)->get()->toArray();

        $dataMetaKri = (new MetaDashboard($getKri))->getMetaDashboard();

        if (sizeof($getKri) != 0) {
            return response()->json([
                "success" => true,
                "data" => array_slice($getKri, 0, 5),
                "meta" => [
                    "data" => $dataMetaKri,
                ],
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $getKri,
                "meta" => [
                    "data" => $dataMetaKri,
                ],
                "message" => "Your data KRI is empty!",
            ]);
        }
    }

    public function getRisks(Request $request)
    {
        $getRisk = RiskRegisters::whereYear("created_at", $request->period)->get()->toArray();

        $dataRisk = [];
        foreach ($getRisk as $key => $risk) {

            $getAnal = Analysis::where("id_risk_register", $risk["id"])->first();
            $getTreat = Treat::where("id_risk_register", $risk["id"])->first();
            $getOrg = Organization::where("id", $risk["id_org"])->first();

            if (isset($risk["objective_category"])) {
                $getObjCat = Objectegory::select("title")->where("id", $risk["objective_category"])->first();

                if ($getObjCat != "" || $getObjCat != null) {
                    $title_cate = ($getObjCat->title == null || $getObjCat->title == "") ? "" : $getObjCat->title;
                } else {
                    $title_cate = "";
                }
            } else {
                $title_cate = "";
            }

            if (isset($getAnal['id_risk_register'])) {
                $scoreBefore = ($getAnal->inherent_risk_score == null || $getAnal->inherent_risk_score == "") ? "" : $getAnal->inherent_risk_score;
                $scoreAfter = ($getAnal->current_risk_score == null || $getAnal->current_risk_score == "") ? "" : $getAnal->current_risk_score;
            } else {
                $scoreBefore = "";
                $scoreAfter = "";
            }

            if (isset($getTreat['id_risk_register'])) {
                $scorePro = ($getTreat->risk_treatment_residual_score == null || $getTreat->risk_treatment_residual_score == "") ? "" : $getTreat->risk_treatment_residual_score;
            } else {
                $scorePro = "";
            }

            $dataDashRisk = [
                "id" => $risk["id"],
                "risk_profile" => $risk["risk_event"],
                "type" => $risk["types"],
                "category" => $title_cate,
                "organization" => $getOrg->name_org,
                "before" => $scoreBefore,
                "after" => $scoreAfter,
                "projection" => $scorePro,
            ];

            array_push($dataRisk, $dataDashRisk);
        }

        if (sizeof($getRisk) != 0) {
            return response()->json([
                "success" => true,
                "data" => $dataRisk,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $dataRisk,
                "message" => "Your data Register is empty!",
            ]);
        }
    }
}
