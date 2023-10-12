<?php

namespace App\Http\Controllers;

use App\Library\Facades\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\{
    Objectegory,
    Log,
    User,
};
use App\Models\General\{
    StatusMapping as Status,
    ReviewLogs as Review,
};
use App\Exports\Governances\ObjectiveCategoryExport as OBC;
use Maatwebsite\Excel\Facades\Excel;

class ObjectegoryController extends Controller
{
    public function getView(\App\Library\GroupPermissions $userdata, Request $request)
    {
        $user = Auth::user();

        $access = [
            'add' => $userdata->hasPermission('add objective_category'),
            'view' => $userdata->hasPermission('view objective_category'),
            'update' => $userdata->hasPermission('update objective_category'),
            'delete' => $userdata->hasPermission('delete objective_category'),
            'approval' => $userdata->hasPermission('approval objective_category'),
            'reviewer' => $userdata->hasPermission('reviewer objective_category'),
        ];

        $query = Objectegory::query();

        if (isset($request->search_data)) {
            $query->where("title", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        if ($user->org_id != 0) {
            $objectegory = $query->whereRaw('(id_organization = 0 OR id_organization = '. $user->org_id .')');
        }

        $objectegory = $query->orderBy("id", "DESC")->paginate(10)->toArray();

        $dataObjCat = [];
        foreach ($objectegory["data"] as $key => $obc) {
            $getStatus["data_status"] = json_decode(json_encode(Status::where("id", $obc["status"])->first()), true);
            $getReview["notes"] = Review::select("review_logs.id as id", "review_logs.module_id", "review_logs.status", "review_logs.notes", "groups.name as reviewer", "review_logs.created_at")->where("page", "=", "Objective Category")->where("module_id", $obc["id"])->join("groups", "review_logs.created_by", "=", "groups.id")->orderBy("review_logs.created_at", "DESC")->get()->toArray();

            $mergeObjCat = array_merge($obc, $getStatus, $getReview);
            array_push($dataObjCat, $mergeObjCat);
        }

        $data_status_mapping = Status::get();
        $data_audit_trails = Log::where('page', "Objective Category")->orderBy('created_at', 'asc')->get();
        return view('pages.governance.objective_category.index')
            ->with('objectegory', json_decode(json_encode($objectegory)))
            ->with('list_objectegory', json_decode(json_encode($dataObjCat)))
            ->with('status_mapping', $data_status_mapping)
            ->with('audit_trails', $data_audit_trails)
            ->with('access', $access)
            ->with('pagination', json_decode(json_encode($objectegory)));
    }

    public function add(Request $request)
    {
        $message = [
            "title.required" => "Please input your Title first!",
            "title.unique" => "This title is already exists!",
        ];

        $validator = Validator::make($request->all(), [
            "title" => "required|unique:objectegory",
        ], $message)->validate();

        try {

            DB::beginTransaction();

            $user = Auth::user();
            $insert = [
                'title' => $request->title,
                'description' => $request->description,
                'id_organization' => $user->org_id,
                'status' => 1,
            ];

            $createObjCat = Objectegory::create($insert);

            DB::commit();

            $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.org_id', $user->org_id)
                ->where('roles.id', 3)
                ->get();

            foreach ($email as $data) {
                Utility::notif("Objective Category", $request, $data, "CREATED");
            }

            Utility::log("Objective Category", $user, $createObjCat->id, $email, "CREATED");


            return redirect('objectegory')->with('addorg', 'Data Objective Category berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('objectegory')->with('addorg', 'Data Objective Category gagal ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $user = Auth::user();
            $updObjCat = Objectegory::where('id', $id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'id_organization' => $user->org_id,
                'status' => 3,
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            DB::commit();

            if ($updObjCat == 1) {
                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                if (sizeof($email) != 0) {
                    foreach ($email as $data) {
                        Utility::notif("Objective Category", $request, $data, "RESUBMITTED");
                    }

                    Utility::log("Objective Category", $user, $id, $email, "RESUBMITTED");
                }

                return redirect('objectegory')->with('update', 'Data Objective Category berhasil diupdate.');
            } else {
                return redirect('objectegory')->with('failed', 'Data Objective Category gagal diupdate.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('objectegory')->with('update', 'Data Objective Category gagal diupdate.');
        }
    }

    public function delete($id)
    {
        DB::table('objectegory')->where('id', $id)->delete();
        return redirect('objectegory')->with('delete', 'Data periods berhasil dihapus.');
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

                Objectegory::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Objective Category", $id, $user, $request->revnotes, "Approved");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Objective Category", $request, $data, "APPROVED");
                }

                Utility::log("Objective Category", $user, $id, $email, "APPROVEDS");
            } else if ($request->input('action') == 'recheck') {
                $update = [
                    'notes' => $request->revnotes,
                    'status' => 2,
                ];

                $email = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.org_id', $user->org_id)
                    ->where('roles.id', 2)
                    ->get();

                Objectegory::where('id', $id)->update($update);

                if ($request->revnotes != "") {
                    $createReview = Utility::reviewLog("Objective Category", $id, $user, $request->revnotes, "Recheck");
                }

                DB::commit();

                foreach ($email as $data) {
                    Utility::notif("Objective Category", $request, $data, "REJECTED");
                }

                Utility::log("Objective Category", $user, $id, $email, "REJECTED");
            }

            return redirect('objectegory')->with('approve', 'Data objectegory berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('objectegory')->with('approve', 'Data objectegory gagal diupdate.');
        }
    }

    public function exportData(Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        $user = Auth::user();

        $query = Objectegory::query();

        if (isset($request->search_data)) {
            $query->where("title", "LIKE", "%" . $request->search_data . "%");
        }

        if (isset($request->status)) {
            $query->where("status", $request->status);
        }

        $objectegory = $query->whereRaw('(id_organization = 0 OR id_organization = '. $user->org_id .')')->get()->toArray();

        $dataObjCat = [];
        foreach ($objectegory as $key => $obc) {
            $getStatus["data_status"] = json_decode(json_encode(Status::where("id", $obc["status"])->first()), true);

            $mergeObjCat = array_merge($obc, $getStatus);
            array_push($dataObjCat, $mergeObjCat);
        }

        return Excel::download(new OBC(json_decode(json_encode($dataObjCat))), 'objective_category-'.date("Y-m-d_H:i:s").'.xlsx');
    }
}
