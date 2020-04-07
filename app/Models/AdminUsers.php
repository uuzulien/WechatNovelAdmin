<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class AdminUsers extends Authenticatable
{

    use Notifiable, SoftDeletes;
    use EntrustUserTrait; // add this trait to your user model
    public $table = 'admin_users';
    public $connection = 'admin';
    protected $hidden = ['password', 'remember_token'];

    /**
     * 解决 EntrustUserTrait 和 SoftDeletes 冲突
     */
    public function restore()
    {
        $this->restoreEntrust();
        $this->restoreSoftDelete();
    }
    public function roleUser(){
     return $this->hasMany(RoleUser::class,'user_id','id');
    }
    public function rolesDetail()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id');
    }

    public function getAuthValidateAttribute()
    {
        return Auth::user()->can('admin_user.delete_user');
    }

}
