<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use App\Models\NovelAdv\PlatformManage;
use App\Models\NovelAdv\AccountManage;

class TaskList extends Model
{
    protected $connection = 'admin';
    protected $table = 'task_list';

    public function hasOnePlatformManage()
    {
        return $this->hasOne(PlatformManage::class, 'id', 'pid');
    }
    public function hasOneAccountManage()
    {
        return $this->hasOne(AccountManage::class, 'id', 'ac_config_id');
    }

    public function getPlatformNickAttribute()
    {
        return $this->hasOnePlatformManage->platform_name ?? null;
    }
    public function getAccoutNameAttribute()
    {
        return $this->hasOneAccountManage->platform_nick ?? null;
    }

    public function getStatusAttribute($value)
    {
        switch ($value){
            case 0:
                return '<b style="color: #333">未运行</b>';
            case 1:
                return '<b style="color: red">运行中</b>';
            case 2:
                return '暂停';
            case 3:
                return '<b style="color: #3fbae4">完成</b>';
            default:
                return '未知';
        }
    }

    public function searchList()
    {
        $query = self::with(['hasOnePlatformManage','hasOneAccountManage'])->orderBy('created_at', 'asc');
        $list = $query->paginate(15);
        return compact('list');
    }

    // 获取配置列表
    public function getConfigList($param)
    {
        $status = $param['status'] ?? 0;
        $count = $param['count'] ?? 4;

        $query = self::with(['hasOneAccountManage'])->orderBy('created_at', 'asc');
        $list = $query->where(['status' => $status])->take($count)->get();

        $configList = [];
        foreach ($list as $key => $item){
            array_push($configList, [
                'platform_nick' => $item->hasOneAccountManage->platform_nick ?? null,
                'account' => $item->hasOneAccountManage->account ?? null,
                'password' => $item->hasOneAccountManage->password ?? null,
                'task_id' => getrandstr() . '_' . $key,
                'id' => $item->id
            ]);
        }

        return $configList;
    }
}
