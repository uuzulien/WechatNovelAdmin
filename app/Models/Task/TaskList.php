<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use App\Models\NovelAdv\PlatformManage;
use App\Models\NovelAdv\AccountManage;
use App\Models\AdminUsers;

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
        return $this->hasOne(AccountManage::class, 'id', 'account_config_id');
    }
    public function hasOneAdminUsers()
    {
        return $this->hasOne(AdminUsers::class, 'id', 'user_id');
    }
    public function hasOneTaskConfigList()
    {
        return $this->hasOne(TaskConfigList::class, 'tid', 'id');
    }

    public function getPlatformNickAttribute()
    {
        return $this->hasOnePlatformManage->platform_name ?? null;
    }
    public function getAccoutNameAttribute()
    {
        return $this->hasOneAccountManage->platform_nick ?? null;
    }
    public function getUserNameAttribute()
    {
        return $this->hasOneAdminUsers->name ?? null;
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
        $query = self::with(['hasOnePlatformManage','hasOneAccountManage','hasOneAdminUsers'])->orderBy('created_at', 'asc');
        $list = $query->paginate(15);
        return compact('list');
    }

    // 获取配置列表
    public function getConfigList($param)
    {
        $status = $param['status'] ?? 0;
        $count = $param['count'] ?? 4;

        $query = self::with(['hasOneAccountManage','hasOneTaskConfigList'])->orderBy('created_at', 'asc');
        $list = $query->where(['status' => $status])->take($count)->get();

        $configList = [];
        foreach ($list as $key => $item){
            array_push($configList, [
                'config_datas' => $item->hasOneTaskConfigList->datas,
                'book_id' => $item->book_id,
                'key' => $item->key,
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
