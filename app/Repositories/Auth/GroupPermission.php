<?php
namespace App\Repositories\Auth;

use App\Models\AdminUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupPermission
{
    // 权限用户组逻辑处理
    public function userGroup($uid = null)
    {
        $user_id = $uid ?? Auth::id();
        $userAdmin = AdminUsers::query()->select(['id', 'role_id','group_id'])->get();

        $groups_id = $userAdmin->where('group_id', $user_id)->pluck('id');

        $sub_group = $userAdmin->pluck('group_id')->intersect($groups_id)->unique()->map(function ($value) use($userAdmin){
            return $userAdmin->where('group_id', $value)->pluck('id');
        })->flatten()->push($user_id);

        return collect(array($groups_id, $sub_group))->collapse()->unique();
    }

    // 获取权限等级树
    public function getGroupTree($userGroup = null)
    {
        $query = DB::connection('admin')->table('admin_users as us')->leftJoin('roles as rs', function ($join) {
                        $join->on('rs.id', '=', 'us.role_id');
                    })->select(['us.name', 'us.id', 'us.group_id', 'rs.grade'])->get();

        $uList = $query->whereIn('id',$userGroup)->sortByDesc('grade');

        $item = [];
        foreach ($uList as $q) {
            if ($q->grade == 2) {
                $oneTree = [
                    'name' => $q->name,
                    'key' => $q->id,
                    'datas' => []
                ];
                $item = $oneTree;
            }
            if ($q->grade == 1) {
                $n = $q->id;
                $twoTree = [
                    'name' => $q->name,
                    'key' => $q->id,
                    'datas' => []
                ];
                array_key_exists('datas', $item) ? $item['datas'][$n] = $twoTree: $item = $twoTree;
            }
            if ($q->grade == 0) {
                $n = $q->group_id;
                $thereTree = [
                    'name' => $q->name,
                    'key' => $q->id,
                    'datas' => []
                ];
                if (array_key_exists('datas', $item)) {
                    array_key_exists($n, $item['datas']) ? array_push($item['datas'][$n]['datas'],$thereTree) :array_push($item['datas'],$thereTree);
                } else {
                    $item = $thereTree;
                }
            }
        }

        return $item;
    }
}
