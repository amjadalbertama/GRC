<?php

namespace App\Http\Controllers\Governances;

use App\Exports\Governances\{
    ReviewImproveExport,
    ReviewDetailsImprovementExport
};
use App\Http\Controllers\Controller;
use App\Models\Control\Audit;
use App\Models\Governances\{
    Programs,
    Periods,
    ReviewImproveManagement,
    ReviewNImprovement,
    ReviewNotesManagement,
};
use App\Models\Objective;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ReviewImprovementController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {

        $rq = $request->all();

        $user = Auth::user();

        // $access = [
        //     'add' => $userdata->hasPermission('add review_n_improvement'),
        //     'view' => $userdata->hasPermission('view review_n_improvement'),
        //     'update' => $userdata->hasPermission('update review_n_improvement'),
        //     'delete' => $userdata->hasPermission('delete review_n_improvement'),
        //     'approval' => $userdata->hasPermission('approval review_n_improvement'),
        //     'reviewer' => $userdata->hasPermission('reviewer review_n_improvement'),
        // ];

        $query = ReviewNImprovement::query();

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if (isset($request->type)) {
            $query->where("type", $request->type);
        }

        if (isset($request->date)) {
            $query->where("date", $request->date);
        }

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(title LIKE '%" . $rq["search_name"] . "%')");
        }

        $evaluasi = $query
            ->orderBy("id", "DESC")
            ->paginate(10);

        $type_review = [
            [
                "id" => 1,
                "type_name" => "Scheduled",
                "index" => 0
            ],
            [
                "id" => 2,
                "type_name" => "Incidental",
                "index" => 1
            ],
        ];

        $status_review = [
            [
                "id" => 1,
                "type_status" => "Open",
                "index" => 0
            ],
            [
                "id" => 2,
                "type_status" => "Done",
                "index" => 1
            ],
        ];
        return view('pages.governance.review_n_improvement.index', [
            'evaluasi' => $evaluasi,
            // 'access' => $access,
            'filter_type' => $type_review,
            'filter_status' => $status_review,
        ]);
    }

    public function details(Request $request, $id)
    {
        $rq = $request->all();
        $getEva = ReviewNImprovement::where('id', $id)->first();
        $query = ReviewImproveManagement::query();

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(description LIKE '%" . $rq["search_name"] . "%')");
        }

        $getRevMnjmt = $query
                    ->orderBy("id", "DESC")
                    ->paginate(10);

        $getRevNote = ReviewNotesManagement::get();
        return view(
            'pages.governance.review_n_improvement.details',
            [
                'revimpove' => $getEva,
                'revmnjmt' => $getRevMnjmt,
                'revnotemnjmt' => $getRevNote,
            ]
        );
    }

    public function modalAddMonev($id)
    {
        $cekDetMonv = ReviewImproveManagement::where('id_review', $id)->where('id_monev', '!=', null)->select('id_monev')->get()->toArray();
        if (isset($cekDetMonv)) {

            $getSmartObj = Objective::leftJoin('periods', 'periods.id', '=', 'objective.id_period')
            ->select('periods.name_periods', 'objective.id as id', 'objective.smart_objectives', 'periods.start_date')
            ->whereNotIn('objective.id', $cekDetMonv)->get();
            $dataobj = [];
            foreach($getSmartObj as $smart){
                    $dataobj[] = [
                        "id" => $smart->id,
                        "title" => $smart->smart_objectives,
                        "name_period" =>$smart->name_periods,
                        "year_monev" => \Carbon\Carbon::parse($smart->start_date)->format('Y')
                    ];
                }
    
                return response()->json([
                    "success" => true,
                    "data" => $dataobj,
                    "cekData" =>$cekDetMonv
                ]);

            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "This data id was not found!"
                ]);
            }
    }

    public function modalAddAudit($id)
    {
        $cekDetAudit = ReviewImproveManagement::where('id_review', $id)->where('id_audit', '!=', null)->select('id_audit')->get()->toArray();

        $getAudit = Audit::leftJoin('organization', 'organization.id', '=', 'audit.id_org')
        ->leftJoin('periods', 'periods.id', '=', 'audit.id_period')
        ->whereNotIn('audit.id', $cekDetAudit)
        ->select('audit.id', 'audit.type', 'audit.source', 'audit.id_source', 'organization.name_org', 'audit.target_date', 'periods.name_periods', 'periods.start_date')
        ->get();
       

        $data = [];
        foreach ($getAudit as $audit) {

                $data[] = [
                    "id" => $audit->id,
                    "type" => $audit->type,
                    "source" => $audit->source,
                    "id_source" => $audit->id_source,
                    "name_org" => $audit->name_org,
                    "name_period" =>$audit->name_periods,
                    "target_date" => \Carbon\Carbon::parse($audit->target_date)->format('d M Y'),
                    "year_audit" => \Carbon\Carbon::parse($audit->start_date)->format('Y')
                ];
     
        }
     
        $currentYear = Carbon::now()->format('Y');
        $lastYear = Carbon::now()->subYear()->format('Y');
        

        if (isset($getAudit)) {
            return response()->json([
                "success" => true,
                "data" => $data,
                "period" => [$currentYear, $lastYear],
            ]);
        }
    }

    public function modalAddProgram($id)
    {

        $cekDetProg = ReviewImproveManagement::where('id_review', $id)->where('id_program', '!=', null)->select('id_program')->get()->toArray(); 
        if (isset($cekDetProg)) {
            $getTilPro1 = Programs::leftJoin('risk_registers', 'risk_registers.id', '=', 'programs.id_risk_register')
            ->leftJoin('objective', 'objective.id', '=', 'risk_registers.id_objective')
            ->leftJoin('periods', 'periods.id', '=', 'objective.id_period')
            ->select('programs.id as id', 'programs.program_title', 'periods.name_periods', 'periods.start_date')
            ->whereNotIn('programs.id', $cekDetProg)->get();
            
            $dataProg = [];
            foreach($getTilPro1 as $prog){
                
                $dataProg[] = [

                    "id" => $prog->id,
                    "title" => $prog->programs_title,
                    "name_period" =>$prog->name_periods,
                    "year_prog" => \Carbon\Carbon::parse($prog->start_date)->format('Y')
                ];
            }
            
            return response()->json([
                "success" => true,
                "data" => $getTilPro1
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "This data id was not found!"
            ]);
        }

    }

    public function viewEdit($id)
    {
        // $rq = $request->all();
        $cekReview = ReviewNImprovement::where('id', $id)->first();
        if (isset($cekReview)) {
            return response()->json([
                "success" => true,
                "data" => $cekReview
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "This data id was not found!"
            ]);
        }
    }

    public function viewEditNotes($id)
    {
        // $rq = $request->all();
        $cekNotes = ReviewNotesManagement::where('id', $id)->first();
        if (isset($cekNotes)) {
            return response()->json([
                "success" => true,
                "data" => $cekNotes
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "This data id was not found!"
            ]);
        }
    }

    public function add(Request $request)
    {
        $rq = $request->all();

        if ((!isset($rq['title'])) || (!isset($rq['type'])) || (!isset($rq['status'])) || (!isset($rq['date'])) || (!isset($rq['perstart']))) {
            return response()->json([
                "success" => false,
                "message" => "All fields cannot be Empty!"
            ]);
        }
        try {
            DB::beginTransaction();

            $getEva = ReviewNImprovement::where('title', $rq['title'])->first();
            if (!isset($getEva->title)) {
                ReviewNImprovement::insert([
                    'title' => $rq['title'],
                    'type' => $rq['type'],
                    'date' => $rq['date'],
                    'status' => $rq['status'],
                    'description' => $rq['descrip'],
                    'start_review_period' => $rq['perstart'],
                    'end_review_period' => $rq['perend'],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
                DB::commit();
                return response()->json([
                    "success" => true,
                    "message" => "add new Review and Improvement Success!"
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Title already exists!"
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('reviewimprove')->with('add', 'Data Review Improvement failed to added.');
        }
    }

    public function addMonev(Request $request)
    {
        $rq = $request->all();

        $cekMonev = ReviewImproveManagement::where('id_review', $rq['id_review'])->get();
        $get_idSelect = $rq['id_MonevSelected'];

       if(!isset($cekMonev->id_monev)){
                for($i = 0; $i < count($get_idSelect); $i++){
                    $getSmart = Objective::where('id', $get_idSelect[$i])->first();
        
                        $createDataMonev = [
                            "id_review" => $rq['id_review'],
                            "id_monev" => $get_idSelect[$i],
                            "title" => "Monev",
                            "description" => "Monev: ". $getSmart->smart_objectives,
                            "status" => 1 
                        ];
        
                        ReviewImproveManagement::create($createDataMonev);
                    }
                return response()->json([
                    "success" => true,
                    "message" => "add Monev Success!"
                ]);
       } else {
            return response()->json([
                "success" => false,
                "message" => "Monev with this id Already Exists!"
            ]);
       }
            
    }

    public function addAudit(Request $request)
    {
        $rq = $request->all();

        $cekAudit = ReviewImproveManagement::where('id_review', $rq['id_review'])->get();
        $get_idSelect = $rq['id_auditSelected'];

        if(!isset($cekAudit->id_audit)){
            for($i = 0; $i < count($get_idSelect); $i++){
                $getAudit = Audit::leftJoin('organization', 'organization.id', '=', 'audit.id_org')
                ->where('audit.id', $get_idSelect[$i])
                ->select('audit.id', 'audit.type', 'audit.source', 'audit.id_source', 'organization.name_org', 'audit.target_date')
                ->first();
                if($getAudit->source != null && $getAudit->id_source != null){
                    $auditDesc = 'Special Audit '. $getAudit->name_org . ' - ('. $getAudit->source . ' / ' . $getAudit->id_source. ')';
                } else{
                    $auditDesc = 'General Audit '.  $getAudit->name_org . ' - ' . $getAudit->target_date;
                }

                $createDataAudit = [
                    "id_review" => $rq['id_review'],
                    "id_audit" => $get_idSelect[$i],
                    "title" => "Audit",
                    "description" => $auditDesc,
                    "status" => 1 
                ];

                ReviewImproveManagement::create($createDataAudit);
            }
            
            return response()->json([
                "success" => true,
                "message" => "add Audit Success!"
            ]);

       }else{
            return response()->json([
                "success" => false,
                "message" => "Monev with this id Already Exists!"
            ]);
       }
            
    }

    public function addProgram(Request $request)
    {
        $rq = $request->all();

        $cekMonev = ReviewImproveManagement::where('id_review', $rq['id_review'])->get();
        $get_idSelect = $rq['id_ProgSelected'];

       if(!isset($cekMonev->id_monev)){
        for($i = 0; $i < count($get_idSelect); $i++){
            $getProg = Programs::where('id', $get_idSelect[$i])->get()->toArray();

            foreach($getProg as $no => $p){

                $createDataProg = [
                    "id_review" => $rq['id_review'],
                    "id_program" => $get_idSelect[$i],
                    "title" => "Program",
                    "description" => $p['program_title'],
                    "status" => 1 
                ];

                ReviewImproveManagement::create($createDataProg);
            }
            
         }
        return response()->json([
            "success" => true,
            "message" => "add Program Success!"
        ]);

       }else{
            return response()->json([
                "success" => false,
                "message" => "Program with this id Already Exists!"
            ]);
       }
            
    }

    public function addNotes(Request $request)
    {
        $rq = $request->all();

        if(!empty($rq['from']) && !empty($rq['descript'])){

            $createDataNotes = [
                "id_review_management" => $rq['id_review'],
                "from" => $rq['from'],
                "description" => $rq['descript'],
                "created_at" => date("Y-m-d H:i:s")
            ];
            $cekNotes = ReviewNotesManagement::create($createDataNotes);
            return response()->json([
                "success" => true,
                "data" => $cekNotes,
                "message" => "add Notes Success!"
            ]);

        }else{
            return response()->json([
                "success" => false,
                "message" => "All field can't be Empty!"
            ]);
        }  
    }

    public function saveEdtNotes(Request $request, $id)
    {
        $rq = $request->all();

        if(!empty($rq['from']) && !empty($rq['descript'])){

            $createDataNotes = [
                "from" => $rq['from'],
                "description" => $rq['descript'],
                "updated_at" => date("Y-m-d H:i:s")
            ];
            $cekNotes = ReviewNotesManagement::where('id', $id)->update($createDataNotes);
            return response()->json([
                "success" => true,
                "data" => $cekNotes,
                "message" => "Update Notes Success!"
            ]);

        }else{
            return response()->json([
                "success" => false,
                "message" => "All field can't be Empty!"
            ]);
        }  
    }

    public function update(Request $request, $id)
    {
        $rq = $request->all();

        if ((!isset($rq['title'])) || (!isset($rq['type'])) || (!isset($rq['status'])) || (!isset($rq['date'])) || (!isset($rq['perstart']))) {
            return response()->json([
                "success" => false,
                "message" => "All fields cannot be Empty!"
            ]);
        }

        try {
            DB::beginTransaction();

            $getEva = ReviewNImprovement::where('id', $id)->get();
            if (isset($getEva)) {
                ReviewNImprovement::where('id', $id)->update([
                    'title' => $rq['title'],
                    'type' => $rq['type'],
                    'date' => $rq['date'],
                    'status' => $rq['status'],
                    'description' => $rq['descrip'],
                    'start_review_period' => $rq['perstart'],
                    'end_review_period' => $rq['perend'],
                    'updated_at' => date("Y-m-d H:i:s")
                ]);

                DB::commit();
                return response()->json([
                    "success" => true,
                    "message" => "Edit Review and Improvement Success!"
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "This ID is not Found!"
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('reviewimprove')->with('update', 'Data Review Improvement failed to Updated.');
        }
    }

    public function delete(Request $request, $id)
    {
        $rq = $request->all();
        if (!empty($rq['delReview'])) {
            $delReview = ReviewNImprovement::where('id', $id)->delete();
            return response()->json([
                "success" => true,
                "data" => $delReview,
                "message" => "Review and Improvement has been Deleted!"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Reason Can't be Empty!"
            ]);
        }
    }

    public function deleteDetails(Request $request, $id)
    {
        $rq = $request->all();
        if (!empty($rq['delDetails'])) {
            $delDetails = ReviewImproveManagement::where('id', $id)->delete();
            return response()->json([
                "success" => true,
                "data" => $delDetails,
                "message" => "Data Details Review and Improvement has been Deleted!"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Reason Can't be Empty!"
            ]);
        }
    }

    public function deleteNotes(Request $request, $id)
    {
        $rq = $request->all();
        if (!empty($rq['delNotes'])) {
            $delNotes = ReviewNotesManagement::where('id', $id)->delete();
            return response()->json([
                "success" => true,
                "data" => $delNotes,
                "message" => "Data Notes Review and Improvement has been Deleted!"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Reason Can't be Empty!"
            ]);
        }
    }

    public function exportData()
    {
        $query = ReviewNImprovement::query();
        $reviewImprove = $query->orderBy("id", "ASC")->get();

        return Excel::download(new ReviewImproveExport($reviewImprove), 'review_n_improvement-' . date("Y-m-d_H:i:s") . '.xlsx');
    }

    public function exportDataDetails($id)
    {
        $querymnjmtrev = ReviewImproveManagement::query();
        $getRevMnjmt = $querymnjmtrev
        ->where("id_review", $id)
        ->orderBy("id", "ASC")
        ->get();
        $getRevNote = ReviewNotesManagement::query();
        $getRevNotes = $getRevNote
        ->where("id_review_management", $id)
        ->orderBy("id", "ASC")
        ->get();
        
        
        return Excel::download(new ReviewDetailsImprovementExport($getRevMnjmt, $getRevNotes), 'review_n_improvement_details-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
