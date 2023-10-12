<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRoleGroupsModelRequest;
use App\Http\Requests\UpdateUserRoleGroupsModelRequest;
use App\Http\Requests\UserRoleGroupsModel;
use App\Library\Facades\Utility;
use App\Models\{
    Groups,
    ModelHasGroup,
    User,
    Roles,
};
use App\Models\Governances\Organization;
use Junges\ACL\Models\Group;
// use Junges\ACL\Models\User;
use Junges\ACL\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $rq = $request->all();

        $query = User::query();

        if (isset($rq["is_active"])) {
            $query->where("is_active", $rq["is_active"]);
        }

        if (isset($rq["search_user"]) && $rq["search_user"] != "" || isset($rq["search_user"]) && $rq["search_user"] != null) {
            $query->whereRaw("(name LIKE '%".$rq["search_user"]."%' OR email LIKE '%".$rq["search_user"]."%')");
        }

        $users = $query->paginate(10)->toArray();

        $dataUser = [];
        foreach ($users["data"] as $key => $user) {
            $groups["group"] = json_decode(json_encode(Group::where("id", $user["group_id"])->first()), true);
            $roles["role"] = json_decode(json_encode(Roles::where("id", $user["role_id"])->first()), true);

            $userMerge = array_merge($user, $groups, $roles);
            array_push($dataUser, $userMerge);
        }

        return view('settings.user.index', [
            'users' => json_decode(json_encode($dataUser)),
            'pagination' => json_decode(json_encode($users)),
        ]);
    }

    public function create(Request $request)
    {
        $group = Group::get();
        $organization = Organization::get();
        $roles = Roles::get();
        return view('settings.user.add', ['groups' => $group, 'organization' => $organization, 'roles' => $roles]);
    }

    public function edit(Request $request, $id)
    {
        $group = Group::get();
        $organization = Organization::get();
        $roles = Roles::get();
        $user = User::where('id', $id)->first();
        return view('settings.user.edit', ['user' => $user, 'groups' => $group, 'organization' => $organization, 'roles' => $roles]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRoleGroupsModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            "name.required" => "Field name is required, cannot be empty!",
            "name.max" => "The length of field name is 255 and you can't input longer than 255!",
            "name.regex" => "Special Character for name is not allowed!",
            "email.required" => "Field email is required, cannot be empty!",
            "email.email" => "Please provide your valid email!",
            "email.unique" => "This email has been taken!",
            "password.required" => "Field password is required, cannot be empty!",
            "password.regex" => "Special Character for password is not allowed!",
            "confirm_pass.required" => "Field password confirmation is required, cannot be empty!",
            "confirm_pass.regex" => "Special Character for password confirmation is not allowed!",
            "confirm_pass.same" => "You have to match with your password!",
            "role_id.required" => "Role ID is required, you have to choose 1 from options!",
            "role_id.not_in" => "You have to choose Role other than this from options!",
            // "organization_id.not_in" => "You have to choose Organization other than this from options!",
        ];

        $validator = Validator::make($request->all(), [
            "name" => "required|regex:/^[a-zA-Z0-9 ]+$/u|string|max:255",
            "email" => "required|email|unique:users|max:255",
            "password" => "required|regex:/^[a-zA-Z0-9 ]+$/u|string",
            "confirm_pass" => "required|regex:/^[a-zA-Z0-9 ]+$/u|required_with:password|same:password",
            "role_id" => "required|not_in:0",
        ], $message)->validate();

        // $usr = User::where(
        //     'name',
        //     '$request->name'
        // )->orWhere(
        //     'email',
        //     '$request->email'
        // )->first();

        // if ($usr !== null) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'User telah ada',
        //     ]);
        // }

        try {
            DB::beginTransaction();

            $create = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'group_id' => $request->group_id,
                'org_id' => $request->organization_id,
                'role_id' => $request->role_id,
                'is_active' => $request->is_active == "on" ? true : false,
            ];

            $user = User::create($create);

            // set user group akses
            $group = Group::where('id', $request->group_id)->first();
            $user->assignGroup($group);

            DB::commit();

            if (isset($user->id)) {
                if ($request->check1 == true) {
                    $email = User::where('id', $user->id)->first();

                    Utility::notif("User", $request, $email, "CREATED");
                }

                return redirect('users')->with('adduser', 'Data User berhasil ditambahkan.');
            } else {
                return redirect('users')->with('adduser', 'Data User gagal ditambahkan.');
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

    public function delete($id)
    {
        $delUser = User::where('id', $id)->delete();

        if ($delUser == 1) {
            return redirect('users')->with('delete', 'Data User berhasil dihapus.');
        } else {
            return redirect('users')->with('delete', 'Data User gagal dihapus.');
        }
    }

    public function update(Request $request, $id)
    {
        $message = [
            "name.required" => "Field name is required, cannot be empty!",
            "name.max" => "The length of field name is 255 and you can't input longer than 255!",
            "name.regex" => "Special Character for name is not allowed!",
            "email.required" => "Field email is required, cannot be empty!",
            "email.email" => "Please provide your valid email!",
            "email.unique" => "This email has been taken!",
            "password.required" => "Field password is required, cannot be empty!",
            "password.regex" => "Special Character for password is not allowed!",
            "confirm_pass.required" => "Field password confirmation is required, cannot be empty!",
            "confirm_pass.regex" => "Special Character for password confirmation is not allowed!",
            "confirm_pass.same" => "You have to match with your password!",
            "role_id.required" => "Role ID is required, you have to choose 1 from options!",
            "role_id.not_in" => "You have to choose Role other than this from options!",
            // "organization_id.not_in" => "You have to choose Organization other than this from options!",
        ];

        $rules = [
            "name" => "required|regex:/^[a-zA-Z0-9 ]+$/u|string|max:255",
            "email" => "required|email|max:255",
            "password" => "required|regex:/^[a-zA-Z0-9 ]+$/u|string",
            "confirm_pass" => "required|regex:/^[a-zA-Z0-9 ]+$/u|required_with:password|same:password",
            "role_id" => "required|not_in:0",
        ];

        if ($request->password == null || $request->password == "") {
            unset($rules["password"]);
            unset($rules["confirm_pass"]);
        }

        $validator = Validator::make($request->all(), $rules, $message)->validate();

        try {

            DB::beginTransaction();

            $update = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'group_id' => $request->group_id,
                'org_id' => $request->organization_id,
                'role_id' => $request->role_id,
                'is_active' => $request->is_active == "on" ? true : false,
            ];

            if ($request->password == null || $request->password == "") {
                unset($update["password"]);
            }

            $updUser = User::where('id', $id)->update($update);

            DB::commit();

            if ($updUser == 1) {
                $cekGroupModel = DB::table("model_has_groups")->where('model_id', $id)->first();
                if (isset($cekGroupModel->model_id)) {
                    $modelHasGroup = DB::table("model_has_groups")->where('model_id', $cekGroupModel->model_id)->update([
                        "group_id" => $request->group_id
                    ]);
                } else {
                    $modelHasGroup = DB::table("model_has_groups")->insert([
                        "model_id" => $id,
                        "model_type" => "App\Models\User",
                        "group_id" => $request->group_id,
                    ]);
                }

                $email = User::where('id', $id)->first();

                Utility::notif("User", $request, $email, "Updated");

                return redirect('users')->with('update', 'Data User berhasil diperbarui.');
            } else {
                return redirect('users')->with('update', 'Tidak ada Data User yang diperbarui.');
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
}
