<?php

namespace App\Http\Controllers\Compliance;

use App\Exports\Compliance\Comcat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Compliance\ComplianceCategory;
use App\Models\Log;
use App\Library\Facades\Utility;
use App\Models\User;
use App\Models\General\{
    StatusMapping,
    ReviewLogs as Review,
};
use Maatwebsite\Excel\Facades\Excel;

class ComplianceCategoryController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {

        $rq = $request->all();

        $user = Auth::user();
        $access = [
            'add' => $userdata->hasPermission('add compliance_category'),
            'view' => $userdata->hasPermission('view compliance_category'),
            'update' => $userdata->hasPermission('update compliance_category'),
            'delete' => $userdata->hasPermission('delete compliance_category'),
            'approval' => $userdata->hasPermission('approval compliance_category'),
            'reviewer' => $userdata->hasPermission('reviewer compliance_category'),
        ];
        $query = ComplianceCategory::query();

        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'compliance_category.status');

        if (isset($request->status)) {
            $query->where("status_mapping.id", $request->status);
        }

        if (isset($request->type)) {
            $query->where("compliance_category.type", $request->type);
        }

        if (!empty($rq["search_name"]) && $rq["search_name"] != "" || !empty($rq["search_name"]) && $rq["search_name"] != null) {
            $query->whereRaw("(compliance_category.name LIKE '%" . $rq["search_name"] . "%')");
        }

        $query->select(
            'compliance_category.id',
            'compliance_category.notes',
            'compliance_category.name',
            'compliance_category.description',
            'status_mapping.status',
            'status_mapping.style',
            'compliance_category.type',
            'compliance_category.status as permission',
            'status_mapping.text as status_text'
        );

        $compliance_category = $query
            ->orderBy("id", "DESC")
            ->paginate(10);

        $audit_trails = Log::where('page', "Compliance Category")->orderBy('created_at', 'asc')->get();
        $user = Auth::user();

        $getReview = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Compliance Category")->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get();
        $data_status_mappings = StatusMapping::get();
        $type = [
            [
                "id" => 1,
                "type" => "Voluntary",
                "index_stat" => 0
            ],
            [
                "id" => 2,
                "type" => "Mandatory",
                "index_stat" => 1
            ],

        ];

        return view('pages.compliance.compliance_category.index', [
            'compliance_category' => $compliance_category,
            'access' => $access,
            'audit_trails' => $audit_trails,
            'user' => $user,
            'review' => $getReview,
            'status_mapping' => $data_status_mappings,
            'type_mapping' => $type,
            'pagination' => json_decode(json_encode($compliance_category))
        ]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $compliance_category = ComplianceCategory::where(
            'name',
            '$request->name',
        )->first();
        if ($compliance_category !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Nama Compliance Category telah ada',
            ]);
        }
        try {
            DB::beginTransaction();
            $insert = [
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ];
            // dd($insert);
            $org_id = ComplianceCategory::insertGetId($insert);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 3)
                ->get();

            $status = 'CREATED';
            foreach ($email as $data) {
                Utility::notif("Compliance Category", $request, $data, $status);
            }
            Utility::log("Compliance Category", $user, $org_id, $email, "CREATED");

            return redirect('complianceCategory')->with('add', 'Data Compliance Category berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('complianceCategory')->with('addwrong', 'Data Compliance Category gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            DB::beginTransaction();

            ComplianceCategory::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'status' => 3,
            ]);
            DB::commit();
            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.id', 3)
                ->get();

            $status = 'RESUBMITTED';
            foreach ($email as $data) {
                Utility::notif("Compliance Category", $request, $data, $status);
            }

            Utility::log("Compliance Category", $user, $id, $email, "RESUBMITTED");

            return redirect('complianceCategory')->with('update', 'Data Compliance Category berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('complianceCategory')->with('updatewrong', 'Data Compliance Category gagal diupdate.');
        }
    }

    public function delete($id)
    {
        DB::table('compliance_category')->where('id', $id)->delete();
        return redirect('complianceCategory')->with('delete', 'Data Objective Category berhasil dihapus.');
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
                        ->where('roles.id', 3)
                        ->get();
                }

                $update = [
                    'notes' => $request->revnotes,
                    'status' => $status,
                ];

                $status = 'APPROVED';

                foreach ($email as $data) {
                    Utility::notif("Compliance Category", $request, $data, $status);
                }

                $user = Auth::user();

                Utility::log("Compliance Category", $user, $id, $email, "APPROVED");

                if ($request->revnotes != "") {
                    Utility::reviewLog("Compliance Category", $id, $user, $request->revnotes, "Approved");
                }

                ComplianceCategory::where('id', $id)->update($update);
                DB::commit();
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id', 2)
                    ->get();
                $status = 'RECHECK';

                foreach ($email as $data) {
                    Utility::notif("Compliance Category", $request, $data, $status);
                }

                $user = Auth::user();
                Utility::log("Compliance Category", $user, $id, $email, "RECHECK");

                if ($request->revnotes != "") {
                    Utility::reviewLog("Compliance Category", $id, $user, $request->revnotes, "Recheck");
                }

                ComplianceCategory::where('id', $id)->update($update);
                DB::commit();
            }

            ComplianceCategory::where('id', $id)->update($update);
            DB::commit();

            return redirect('complianceCategory')->with('approve', 'Data Objective Category berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('organization')->with('updatewrong', 'Data organisasi gagal di Approve.');
        }
    }

    public function exportData()
    {

        $query = ComplianceCategory::query();
        $query->leftJoin('status_mapping', 'status_mapping.id', '=', 'compliance_category.status');
        $query->select(
            'compliance_category.id',
            'compliance_category.name',
            'compliance_category.description',
            'status_mapping.status',
            'compliance_category.type',
        );

        $compliance_category = $query
            ->orderBy("id", "ASC")
            ->get();

        return Excel::download(new Comcat($compliance_category), 'Compliance_Category-' . date("Y-m-d_H:i:s") . '.xlsx');
    }
}
