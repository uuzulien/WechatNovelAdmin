<?php
namespace App\Repositories\Auth;

use App\Models\AdminUsers;
use Illuminate\Support\Facades\Auth;

class GroupPermission
{
    // 权限用户组逻辑处理
    public function userGroup()
    {
        $user_id = Auth::id();
        $userAdmin = AdminUsers::query()->select(['id', 'role_id','group_id'])->get();

        $groups_id = $userAdmin->where('group_id', $user_id)->pluck('id');

        $sub_group = $userAdmin->pluck('group_id')->intersect($groups_id)->unique()->map(function ($value) use($userAdmin){
            return $userAdmin->where('group_id', $value)->pluck('id');
        })->flatten()->push($user_id);

        return collect(array($groups_id, $sub_group))->collapse()->unique();
    }
}
