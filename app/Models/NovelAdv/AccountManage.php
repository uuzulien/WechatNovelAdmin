<?php

namespace App\Models\NovelAdv;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminUsers;
use App\Models\GroupUsers;
use Illuminate\Support\Facades\Auth;

class AccountManage extends Model
{
    protected $connection = 'admin';
    protected $table = 'account_config';

    public function hasBelongsToAccountAdv()
    {
        return $this->belongsTo(PlatformManage::class, 'pid' , 'id');
    }

    public function hasOneUser()
    {
        return $this->hasOne(AdminUsers::class, 'id', 'user_id');
    }

    public function getPlatformAttribute()
    {
        return $this->hasBelongsToAccountAdv->platform_name ?? '-';
    }

    public function getOperatorAttribute()
    {
        return $this->hasOneUser->name ?? '-';
    }

    public function searchList($data)
    {
        $key = $data['key'] ?? null;
        $word = $data['word'] ?? null;
        $pid = $data['pt_type'] ?? null;
        $status = $data['status'] ?? null;
        $type = $data['type'] ?? null;
        unset($data);

        $query = self::with(['hasOneUser','hasBelongsToAccountAdv']);

        $groups = (new GroupUsers())->where('group_id', Auth::id())->get()->pluck('user_id')->push(Auth::id()); // 小组临时权限控制

        $list = $query->when($word, function ($q) use($key,$word) {
                    if ($key == 'pfname') {
                        return $q->where('platform_nick','like', "%$word%");
                    }
                    return $q->where('account', 'like', "%$word%");
                })->when($pid, function ($q) use($pid) {
                    $q->where('pid', $pid);
                })->when($status, function ($q) use($status) {
                    $q->where('status', $status);
                })->when($type, function ($q) use($type) {
                    $q->whereHas('hasBelongsToAccountAdv', function ($q) use($type) {$q->where('type',$type);});
                })->when(Auth::id()!= 1,function ($q) use($groups) {$q->whereIn('user_id', $groups);})->orderBy('created_at', 'asc')->paginate(15);

        $platforms = (new PlatformManage())->where('type', '1')->get(['id','platform_name'])->pluck('platform_name','id');

        return compact('list', 'platforms');
    }
}
