<?php

namespace App\Http\Controllers\Compliance;

use App\Exports\Compliance\Comreg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Compliance\{
    ComplianceRegister,
    ComplianceCategory,
    typeRatingCompliance,
    TypeStatusFulfilled
};
use App\Http\Controllers\Controller;
use App\Models\{
    Objective,
    RiskAppetite,
    RiskIdentification,
};
use App\Models\Governances\Organization;
use App\Models\Risks\{
    RiskRegisters,
    RiskRegisterTreatments,
    RiskRegisterIdentifications as Identifications,
};
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class ComplianceRegisterController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $rq = $request->all();
        $user = Auth::user();
        $access = [
            'add' => $userdata->hasPermission('add compliance_register'),
            'view' => $userdata->hasPermission('view compliance_register'),
            'update' => $userdata->hasPermission('update compliance_register'),
            'delete' => $userdata->hasPermission('delete compliance_register'),
            'approval' => $userdata->hasPermission('approval compliance_register'),
            'reviewer' => $userdata->hasPermission('reviewer compliance_register'),
        ];
        $query = ComplianceRegister::query();
        $query->leftJoin('compliance_category', 'compliance_category.id', '=', 'compliance_register.id_compliance_category');
        $query->leftJoin('risk_registers', 'risk_registers.id', '=', 'compliance_register.risk_id');
        $query->leftJoin('risk_identifications', 'risk_identifications.id', '=', 'risk_registers.id_risk_identification');
        $query->leftJoin('risk_register_treatments', 'risk_register_treatments.id_risk_register', '=', 'risk_registers.id');
        $query->leftJoin('objective', 'objective.id', '=', 'compliance_register.objective_id');
        $query->leftJoin('organization', 'organization.id', '=', 'compliance_register.organization');
        $query->leftJoin('compliance_status_fulfilled', 'compliance_status_fulfilled.id', '=', 'compliance_register.fulfillment_status');
        $query->leftJoin('type_rating_compliance', 'type_rating_compliance.id', '=', 'compliance_register.rating');

        if ($user->org_id != 0) {
            $query->where('organization.id', $user->org_id);
        }

        if (isset($request->status)) {
            $query->where("compliance_status_fulfilled.id", $request->status);
        }

        if (isset($request->cate)) {
            $query->where("compliance_category.id", $request->cate);
        }

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(compliance_register.compliance LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'compliance_register.id',
            'compliance_register.compliance',
            'compliance_register.objective_id',
            'compliance_register.compliance_owner',
            'compliance_category.name as category_name',
            'compliance_status_fulfilled.name_status as status_fulfilled',
            'compliance_status_fulfilled.style_status',
            'organization.id as id_org',
            'organization.name_org',
            'type_rating_compliance.name_rating',
            'type_rating_compliance.style_rating',
            'objective.smart_objectives',
            'risk_registers.id as risk_id',
            'risk_identifications.risk_event',
            'risk_register_treatments.risk_treatment_strategy',
        );

        $compliance_register = $query
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $data_status_mappings = TypeStatusFulfilled::get();
        $data_category_mappings = ComplianceCategory::get();
        return view('pages.compliance.compliance_register.index', [
            'compliance_register' => $compliance_register,
            'access' => $access,
            'status_mapping' => $data_status_mappings,
            'cate_mapping' => $data_category_mappings,
            'pagination' => json_decode(json_encode($compliance_register))
        ]);
    }

    public function detailsComplianceReg(\App\Library\GroupPermissions $userdata, $id)
    {

        $access = [
            'add' => $userdata->hasPermission('add compliance_register'),
            'view' => $userdata->hasPermission('view compliance_register'),
            'update' => $userdata->hasPermission('update compliance_register'),
            'delete' => $userdata->hasPermission('delete compliance_register'),
            'approval' => $userdata->hasPermission('approval compliance_register'),
            'reviewer' => $userdata->hasPermission('reviewer compliance_register'),
        ];

        $getComreg = json_decode(json_encode(ComplianceRegister::where('id', $id)->first()), true);
        // $getCatcomreg = json_decode(json_encode(Compliance_category::where('id', $getComreg["id_compliance_category"])->first()), true);
        // $getStatus = json_decode(json_encode(TypeStatusFulfilled::where('id', $getComreg["fulfillment_status"])->first()), true);
        $getObj = json_decode(json_encode(Objective::where('id', $getComreg["objective_id"])->first()), true);
        $getRisk = json_decode(json_encode(RiskRegisters::where('id', $getComreg["risk_id"])->first()), true);
        $getOrg = json_decode(json_encode(Organization::where('id', $getComreg["organization"])->first()), true);


        if (isset($getComreg["fulfillment_status"])) {
            $getStatus = json_decode(json_encode(TypeStatusFulfilled::where('id', $getComreg["fulfillment_status"])->get()), true);
        } else {
            $getStatus = [];
        }
        if (isset($getComreg["id_compliance_category"])) {
            $getCatcomreg = json_decode(json_encode(ComplianceCategory::where('id', $getComreg["id_compliance_category"])->get()), true);
        } else {
            $getCatcomreg = [];
        }

        if ($getComreg["rating"] != null || $getComreg["rating"] != 0 || $getComreg["rating"] != "") {
            $getRating = json_decode(json_encode(typeRatingCompliance::where('id', $getComreg["rating"])->first()), true);
        } else {
            $getRating = [];
        }

        if (isset($getRisk["id"])) {
            $getRiskTreat = json_decode(json_encode(RiskRegisterTreatments::where('id_risk_register', $getRisk["id"])->first()), true);
            if (!isset($getRiskTreat)) {
                $getRiskTreat = [];
            }
        } else {
            $getRiskTreat = [];
        }


        $dataCate["compliance_category"] = $getCatcomreg;
        $dataStatus["status"] = $getStatus;
        $dataRating["rating"] = $getRating;
        $dataObj["objective"] = $getObj;
        $dataRisk["risk_event"] = $getRisk;
        $dataOrg["organizations"] = $getOrg;
        $dataRiskTreat["treatment"] = $getRiskTreat;

        $mergeComreg = array_merge($getComreg, $dataCate, $dataStatus, $dataRating, $dataObj, $dataOrg, $dataRisk, $dataRiskTreat);
        // print_r(json_encode($dataOrg["organizations"]));
        // die;
        $getAllCate = ComplianceCategory::get()->toArray();

        if (isset($mergeComreg['id'])) {
            return response()->json([
                "success" => true,
                "data" => $mergeComreg,
                "cate" => $getAllCate,
                "access" => $access,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "cate" => [],
                "access" => [],
            ]);
        }
    }


    public function add(Request $request)
    {
        $obcat = ComplianceRegister::where(
            'risk_id',
            '$request->risk_id'
        )->first();
        if ($obcat !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Group telah ada',
            ]);
        }
        try {
            DB::beginTransaction();
            ComplianceRegister::create([
                'risk_id' => $request->risk_id,
                'compliance' => $request->compliance,
                'rating' => $request->rating,
                'organization' => $request->organization,
                'objective_id' => $request->objective_id,
            ]);
            Auth::user();
            DB::commit();
            return redirect('complianceRegister')->with('add', 'Data Compliance Register berhasil ditambahkan.');
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

    public function generateCompliance(Request $request, $id)
    {
        $user = Auth::user();
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
        $getObjIde = RiskIdentification::where("id", $rq["idIden"])->first();
        $checkRisk = RiskRegisters::where("id_objective", $rq['id'])->where("id_risk_identification", $rq["idIden"])->first();

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
            $insRr = RiskRegisters::create($dataInsRr);

            //Gen Compliance


            if (isset($insRr->id)) {
                $dataIde = [
                    "id_risk_register" => $insRr->id,
                    "risk_event_event" => $getObjIde->risk_event,
                    "risk_event_category" => $insRr->objective_category,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                $insIde = Identifications::create($dataIde);

                $getOrg = Organization::where("id", $user->org_id)->first();
                $getOwner = User::where("id", $getOrg->lead_role)->first();
                $getRisk = RiskRegisters::where("id", $insRr->id)->first();

                if (isset($insRr->id)) {
                    $rating = ($insRr->id_impact == null || $insRr->id_impact == 0) ? 0 : $insRr->id_impact;
                } else {
                    $rating = 0;
                }

                $dataCompliance = [
                    'compliance' => $getObjIde->risk_event,
                    'risk_id' => $getRisk->id,
                    'rating' => $rating,
                    'organization' => $getOrg->id,
                    'objective_id' => $getObjIde->id_objective,
                    'compliance_owner' => $getOwner->name,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                $dataComp = ComplianceRegister::create($dataCompliance);

                return response()->json([
                    "success" => true,
                    "data" => $dataComp,
                    "message" => "Berhasil Generate Risk dan Compliance",
                ]);
            } else {
                return response()->json([
                    "success" => true,
                    "data" => [],
                    "message" => "Gagal Generate, Error Create data Identification",
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Gagal Generate Risk dan Compliance",
            ]);
        }
    }

    public function saveCompreg(Request $request, $id)
    {
        $rq =  $request->all();
        $cekData = ComplianceRegister::where('id', $id)->first();

        if (isset($cekData->id)) {
            $dataUpdate = [
                'id_compliance_category' => $rq['cate_id'],
                'fulfillment_status' => $rq['status_id'],
            ];
            ComplianceRegister::where('id', $id)->update($dataUpdate);
            return response()->json([
                "success" => true,
                "message" => "",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "",
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            ComplianceRegister::where('id', $id)->update([
                'risk_id' => $request->risk_id,
                'compliance' => $request->compliance,
                'rating' => $request->rating,
                'organization' => $request->organization,
                'objective_id' => $request->objective_id,
            ]);
            DB::commit();
            return redirect('complianceRegister')->with('update', 'Data Compliance Register berhasil diupdate.');
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

    public function delete($id)
    {
        DB::table('compliance_register')->where('id', $id)->delete();
        return redirect('complianceRegister')->with('delete', 'Data Compliance Register berhasil dihapus.');
    }

    public function exportData()
    {

        $query = ComplianceRegister::query();
        $query->leftJoin('compliance_category', 'compliance_category.id', '=', 'compliance_register.id_compliance_category');
        $query->leftJoin('risk_registers', 'risk_registers.id', '=', 'compliance_register.risk_id');
        $query->leftJoin('organization', 'organization.id', '=', 'compliance_register.organization');
        $query->leftJoin('compliance_status_fulfilled', 'compliance_status_fulfilled.id', '=', 'compliance_register.fulfillment_status');
        $query->leftJoin('type_rating_compliance', 'type_rating_compliance.id', '=', 'compliance_register.rating');
        $query->select(
            'compliance_register.id',
            'compliance_register.compliance',
            'compliance_register.objective_id',
            'compliance_category.name as category_name',
            'compliance_status_fulfilled.name_status as status_fulfilled',
            'organization.name_org',
            'type_rating_compliance.name_rating',
            'risk_registers.id as risk_id',
        );

        $compliance_register = $query
            ->orderBy("id", "ASC")
            ->get();

        return Excel::download(new Comreg($compliance_register), 'Compliance_Register-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
