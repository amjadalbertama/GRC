<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreUserRoleGroupsModelRequest;
use App\Http\Requests\UpdateUserRoleGroupsModelRequest;
use App\Http\Requests\UserRoleGroupsModel;
use App\Models\{
    User,
    GroupHasPermission,
};
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;


class HakAksesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:sanctum', [
            'except' => [
                'index',
                'detail',
                'delete',
                'createPermission',
                'create',
                'store',
                'show',
                'edit',
                'update',
                'updateAcc',
                'destroy',
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::paginate(10);
        return view('settings.hak_akses.index', ['groups' => json_decode(json_encode($groups))]);
    }

    public function detail(Request $request, $id)
    {
        $group = Group::where("id", $id)->first();
        $pages = $request->session()->get('pages');
        
        $getPages = $this->makePages($pages, $id);

        return view('settings.hak_akses.edit', [
            'group' => $group,
            'pages' => $getPages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pages = $request->session()->get('pages');

        return view('settings.hak_akses.add', compact('pages'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRoleGroupsModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRoleGroupsModelRequest $request)
    {
        $grp = Group::where('name', '$request->name')->first();

        if ($grp !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Group telah ada',
            ]);
        }

        try {
            // keterangan
            // all => c r u d
            // read => read only
            // edit => update
            // none => mo akses

            // create group first
            // make permissions
            DB::beginTransaction();

            $group = Group::create([
                'name' => $request->name,
                'is_active' => $request->is_active == 'on' ? 1 : 0 
            ]);

            $permissions = $request->permission;
            
            foreach ($permissions as $permission => $value) {
                if ($value != 'none') {
                    $this->createPermission($permission, $value, $group);
                }
            }

            DB::commit();

            if (isset($group->id)) {
                return response()->json([
                    "success" => true,
                    "data" => $group,
                    "message" => "Data Groups berhasil ditambahkan.",
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Data Groups gagal ditambahkan.",
                ]);
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

        // return redirect('hakakses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRoleGroupsModel  $userRoleGroupsModel
     * @return \Illuminate\Http\Response
     */
    public function show(UserRoleGroupsModel $userRoleGroupsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRoleGroupsModel  $userRoleGroupsModel
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRoleGroupsModel $userRoleGroupsModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRoleGroupsModelRequest  $request
     * @param  \App\Models\UserRoleGroupsModel  $userRoleGroupsModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRoleGroupsModelRequest $request, UserRoleGroupsModel $userRoleGroupsModel, $id)
    {
        // $grp = Group::where('name', '$request->name')->first();

        // if ($grp !== null) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Group telah ada',
        //     ]);
        // }

        try {
            // keterangan
            // all => c r u d
            // read => read only
            // edit => update
            // none => mo akses

            // create group first
            // make permissions
            DB::beginTransaction();

            $group = Group::where('id', $id)->first();
            $updateGroup = Group::where('id', $id)->update([
                'name' => $group->name,
                'is_active' => $request->is_active == 'on' ? 1 : 0 
            ]);

            $permissions = $request->permission;
            
            foreach ($permissions as $permission => $value) {
                if ($value != 'none') {
                    $data = $this->createPermission($permission, $value, $group);
                }
            }

            DB::commit();

            return redirect('/hakakses')->with('access', 'Data Groups berhasil ditambahkan.');
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

    /**
     * Update the specified route in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRoleGroupsModelRequest  $request
     * @param  \App\Models\UserRoleGroupsModel  $userRoleGroupsModel
     * @return \Illuminate\Http\Response
     */
    public function updateAcc(UpdateUserRoleGroupsModelRequest $request, UserRoleGroupsModel $userRoleGroupsModel, $id)
    {
        // $grp = Group::where('name', '$request->name')->first();

        // if ($grp !== null) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Group telah ada',
        //     ]);
        // }

        try {
            // keterangan
            // all => c r u d
            // read => read only
            // edit => update
            // none => mo akses

            // create group first
            // make permissions
            DB::beginTransaction();

            $group = Group::where('id', $id)->first();
            $updateGroup = Group::where('id', $id)->update([
                'name' => $group->name,
                'is_active' => $request->is_active == 'on' ? 1 : 0 
            ]);

            $permissions = $request->permission;
            
            $i = 0;
            $arrGroup = [];
            foreach ($permissions as $permission => $value) {
                if ($value != 'none') {
                    $cpms = $this->createPermissions($permission, $value, $group);
                    if (sizeof($cpms) != 0) {
                        array_push($arrGroup, $cpms[0]);
                    }
                }
                $i++;
            }

            $pivotGroup = [];
            $resultUpdate = [];
            foreach ($arrGroup as $key => $pms) {
                foreach (array_values($pms)[0] as $n => $pid) {
                    $makePivot = [
                        "group_id" => $id,
                        "permission_id" => $pid,
                    ];
                    array_push($pivotGroup, $makePivot);
                }
            }

            $cekPermission = GroupHasPermission::where("group_id", $id)->get();

            $resDel = null;
            if (sizeof($cekPermission) != 0) {
                $delPermission = GroupHasPermission::where("group_id", $id)->delete();

                if ($delPermission != 0) {
                    $resDel = $delPermission;
                }
            }

            if ($resDel != 0) {
                $inpPermissionEl = GroupHasPermission::insert($pivotGroup);

                array_push($resultUpdate, $inpPermissionEl);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $resultUpdate,
                'message' => 'Data Groups berhasil diubah.',
            ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRoleGroupsModel  $userRoleGroupsModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRoleGroupsModel $userRoleGroupsModel, $id)
    {
        DB::table('groups')->where('id', $id)->delete();
        return redirect('/hakakses')->with('access', 'Data Groups berhasil dihapus.');
    }

    private function createPermission($permission, $value, $group, $group_id = -1)
    {
        $id_add = Permission::where('name', str_replace('\'','', 'add ' . $permission))->first();
        $id_view = Permission::where('name', str_replace('\'','', 'view ' . $permission))->first();
        $id_update = Permission::where('name', str_replace('\'','', 'update ' . $permission))->first();
        $id_delete = Permission::where('name', str_replace('\'','', 'delete ' . $permission))->first();
        $id_approval = Permission::where('name', str_replace('\'','', 'approval ' . $permission))->first();
        $id_reviewer = Permission::where('name', str_replace('\'','', 'reviewer ' . $permission))->first();

        switch ($value) {
            case 'all':
                $group->assignPermission($id_add);
                $group->assignPermission($id_view);
                $group->assignPermission($id_update);
                $group->assignPermission($id_delete);
                break;
            case 'read':
                $group->assignPermission($id_view);
                break;
            case 'edit':
                $group->assignPermission($id_view);
                $group->assignPermission($id_update);
                break;
            case 'approval':
                $group->assignPermission($id_view);
                $group->assignPermission($id_approval);
                break;
            case 'reviewer':
                $group->assignPermission($id_view);
                $group->assignPermission($id_reviewer);
                break;
        }
    }

    private function createPermissions($permission, $value, $group, $group_id = -1)
    {
        $id_add = Permission::where('name', str_replace('\'','', 'add ' . $permission))->first();
        $id_view = Permission::where('name', str_replace('\'','', 'view ' . $permission))->first();
        $id_update = Permission::where('name', str_replace('\'','', 'update ' . $permission))->first();
        $id_delete = Permission::where('name', str_replace('\'','', 'delete ' . $permission))->first();
        $id_approval = Permission::where('name', str_replace('\'','', 'approval ' . $permission))->first();
        $id_reviewer = Permission::where('name', str_replace('\'','', 'reviewer ' . $permission))->first();

        $permission = str_replace("'", "", $permission);

        $arrPms = [];

        switch ($value) {
            case 'all':
                if (isset($id_view->id)) {
                    $dataAll[$permission] = [
                        $id_add->id,
                        $id_view->id,
                        $id_update->id,
                        $id_delete->id,
                    ];
                    array_push($arrPms, $dataAll);
                }
                break;
            case 'read':
                if (isset($id_view->id)) {
                    $dataRead[$permission] = [
                        $id_view->id,
                    ];
                    array_push($arrPms, $dataRead);
                }
                break;
            case 'edit':
                if (isset($id_view->id)) {
                    $dataEdit[$permission] = [
                        $id_view->id,
                        $id_update->id,
                    ];
                    array_push($arrPms, $dataEdit);
                }
                break;
            case 'approval':
                if (isset($id_view->id)) {
                    $dataApproval[$permission] = [
                        $id_view->id,
                        $id_approval->id,
                    ];
                    array_push($arrPms, $dataApproval);
                }
                break;
            case 'reviewer':
                if (isset($id_view->id)) {
                    $dataReviewer[$permission] = [
                        $id_view->id,
                        $id_reviewer->id,
                    ];
                    array_push($arrPms, $dataReviewer);
                }
                break;
        }

        return $arrPms;
    }

    private function revertPermission($pages, $permissions)
    {
        
    }

    private function makePages($pages, $id)
    {
        $newPages = [];
        $listPermission = [];
        foreach ($pages as $key => $pg) {
            $dataPage = [
                "page_group" => $pg["page_group"],
                "data" => [],
            ];
            foreach ($pg["data"] as $keys => $pm) {
                $getPermissions = Permission::leftJoin("group_has_permissions as ghp", "permissions.id", "=", "ghp.permission_id")->where("ghp.group_id", $id)->where("permissions.name", "LIKE", "%".$pm["permission"]."%")->select("permissions.id as id", "permissions.name as name")->distinct("permissions.id")->get()->toArray();

                $mapped = array_map(function ($value) {
                    $breaking = explode(" ", $value["name"]);
                    return $breaking[0];
                }, $getPermissions);
                $toStr = implode(", ", $mapped);    

                if (in_array("add", $mapped) && in_array("view", $mapped) && in_array("update", $mapped) && in_array("delete", $mapped)) {
                    $valPermission = "all";
                } elseif (in_array("view", $mapped) && in_array("update", $mapped)) {
                    $valPermission = "edit";
                } elseif (in_array("view", $mapped) && in_array("approval", $mapped)) {
                    $valPermission = "approval";
                } elseif (in_array("view", $mapped) && in_array("reviewer", $mapped)) {
                    $valPermission = "reviewer";
                } elseif (in_array("view", $mapped)) {
                    $valPermission = "read";
                } else {
                    $valPermission = "deny";
                }

                $objPage = [
                    "page" => $pm["page"],
                    "group_id" => intval($id),
                    "permission" => $pm["permission"],
                    "value" => $valPermission,
                ];

                array_push($dataPage["data"], $objPage);
            }
            array_push($newPages, $dataPage);
        }

        return $newPages;
    }
}
