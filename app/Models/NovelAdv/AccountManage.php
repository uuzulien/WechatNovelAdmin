<?php

namespace App\Models\NovelAdv;

use Illuminate\Database\Eloquent\Model;
use App\Models\NovelAdv\PlatformManage;
use App\Models\AdminUsers;
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
        $platform_name = $data['pfname'] ?? null;
        $account = $data['account'] ?? null;
        $pid = $data['pt_type'] ?? null;
        $status = $data['status'] ?? null;
        $type = $data['type'] ?? null;
        unset($data);

        $query = self::with(['hasOneUser','hasBelongsToAccountAdv']);

        $list = $query->when($platform_name, function ($q) use($platform_name) {
                   $q->where('platform_name', $platform_name);
                })->when($account, function ($q) use($account) {
                    $q->where('account',$account);
                })->when($pid, function ($q) use($pid) {
                    $q->where('pid', $pid);
                })->when($status, function ($q) use($status) {
                    $q->where('status', $status);
                })->when($type, function ($q) use($type) {
                    $q->whereHas('hasBelongsToAccountAdv', function ($q) use($type){$q->where('type',$type);});
                })->orderBy('created_at', 'asc')->paginate(15);

        return compact('list');
    }
}
