<?php
/*
 * Group Permissions
 * check permisi di dalam group yang dimiliki oleh user 
 */

namespace App\Library;

use Illuminate\Support\Facades\Auth;
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;
use App\Models\GroupHasPermission;
use App\Models\ModelHasPermission;
use App\Models\ModelHasGroup;

class GroupPermissions
{
    public function has($group_id, $permission)
    {
        $permission_id = Permission::where('name', $permission)->first()->id;
        if(GroupHasPermission::where(['group_id' => $group_id, 'permission_id' => $permission_id])->count()) return true;
        return false;
    }

    public function userGroupId()
    {
        $user = Auth::user();

        $getGroup = ModelHasGroup::where([
            'model_id' => $user->id,
            'model_type' => 'App\Models\User'
        ])->first();

        if (isset($getGroup->group_id)) {
            return $getGroup->group_id;
        } else {
            return 111111;
        }
    }

    public function hasPermission($permission)
    {
        $group_id = $this->userGroupId();
        return $this->has($group_id, $permission);
    }
}
