<?php
/**
 * Created by PhpStorm.
 * Date: 2018/4/2/002
 * Time: 10:44
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\NovelAdv\AccountManage;


class RoleUser extends Model
{
    protected $connection = 'admin';
    protected $table = 'role_user';

    public function role(){
        return $this->hasOne(Role::class,'id','role_id');
    }
    public function adminUsers(){
        return $this->hasOne(AdminUsers::class,'id','user_id');
    }
    public function hasManyAccountManage(){
        return $this->hasMany(AccountManage::class,'user_id','user_id');
    }

}
