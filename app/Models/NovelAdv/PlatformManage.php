<?php

namespace App\Models\NovelAdv;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task\TaskConfigList;

class PlatformManage extends Model
{
    protected $connection = 'admin';
    protected $table = 'platform_config';

    public function hasManyTaskConfigList()
    {
        return $this->hasMany(TaskConfigList::class, 'pid', 'id');
    }

    public function getTaskConfigNameAttribute()
    {
        return $this->hasManyTaskConfigList->name ?? '未配置规则';
    }
}
