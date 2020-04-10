<?php

namespace App\Models\Task;

use App\Models\NovelAdv\PlatformManage;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminUsers;

class TaskConfigList extends Model
{
    protected $connection = 'admin';
    protected $table = 'task_config_list';

    public function hasOnePlatformManage()
    {
        return $this->hasOne(PlatformManage::class, 'id', 'pid');
    }

    public function hasOneAdminUsers()
    {
        return $this->hasOne(AdminUsers::class, 'id', 'user_id');
    }

    public function getUserNameAttribute()
    {
        return $this->hasOneAdminUsers->name ?? '-';
    }

    public function getPlatformNameAttribute()
    {
        return $this->hasOnePlatformManage->platform_name ?? '-';
    }

    // 配置样式美化
    public function getConfigDataAttribute()
    {
        $data = json_decode($this->datas);
        $html = '';
        foreach ($data as $key => $value) {
            $html = "<span> <b style='color: red'>$key</b> ： $value </span><br>" . $html;
        }
        return $html;
    }

    public function searchList()
    {
        $query = self::with(['hasOnePlatformManage','hasOneAdminUsers'])->orderBy('created_at', 'asc');
        $list = $query->paginate(15);

        return compact('list');
    }
}
