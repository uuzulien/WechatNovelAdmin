<?php

namespace App\Models\Task;

use App\Repositories\Auth\GroupPermission;
use Illuminate\Database\Eloquent\Model;
use App\Models\NovelAdv\PlatformManage;
use App\Models\NovelAdv\AccountManage;
use App\Models\AdminUsers;
use App\Models\AcceptHandleLog;

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
        return $this->hasOne(TaskConfigList::class, 'id', 'task_config_id');
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
    public function getTaskConfigNameAttribute()
    {
        return $this->hasOneTaskConfigList->name ?? '-';
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
        $userGroup = (new GroupPermission())->userGroup();

        $query = self::with(['hasOnePlatformManage','hasOneAccountManage','hasOneAdminUsers','hasOneTaskConfigList'])
            ->whereHas('hasOneAccountManage', function ($query) use($userGroup){
                    $query->whereIn('user_id', $userGroup);
                })->orderBy('created_at', 'asc');

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
        $FunArr = array(
                '1' => ['get_book_page_list','for_sliced_book'],
                '2' => ['get_book_page_list','for_sliced_book'],
                '3' => ['for_order_page','for_sliced_order'],
                '4' => ['for_fens_page']
            );
        foreach ($list as $key => $item){
            $config_data = $item->hasOneTaskConfigList->datas ?? null;
            $data = [
                'datas' => $config_data ? json_decode($config_data) : null,
                'book_id' => $item->book_id,
                'class' => $item->hasOneTaskConfigList->func ?? null,
                'func' => $FunArr[$item->key],
                'key' => $item->key,
                'platform_nick' => $item->hasOneAccountManage->platform_nick ?? null,
                'account' => $item->hasOneAccountManage->account ?? null,
                'password' => $item->hasOneAccountManage->password ?? null,
                'run_id' => getrandstr() . '_' . $key,
                'politic' => $item->politic,
                'breakpoint' => $status ? $this->BreakPointAcq($item->id): null,
                'pid' => $item->pid,
                'id' => $item->id,
                'pt_id' => $item->account_config_id
            ];

            if ($config_data)
                array_push($configList, $data);
        }

        return $configList;
    }

    public function BreakPointAcq($task_id)
    {
        $query = AcceptHandleLog::query()->where(['tid' => $task_id, 'politic' => 1])->orderBy('created_at','DESC')->pluck('breakpoint');
        return $query->first();
    }
}
