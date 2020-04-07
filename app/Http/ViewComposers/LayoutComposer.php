<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Auth\UserPermission;

class LayoutComposer
{

    protected $adminService;
    protected $request;

    public function __construct( UserPermission $userPermission,Request $request)
    {
        $this->adminService = $userPermission;
        $this->request = $request;
    }

    /**
     * 绑定数据给view
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Auth::user();
        if (Auth::check()) { //判断用户是否登录
            //从UAMS获得菜单信息
            $menu=$this->adminService->userMenu($user);
            //附加管理员信息
            $view->with('user', $user);
            //附加菜单信息
            $view->with('menu',$menu);
        }
    }
}