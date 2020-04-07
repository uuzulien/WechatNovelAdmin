<?php


namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{
    const platformType = 2;
    /**
     * 投放账号管理首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request,AccountManage $accountManage)
    {
        $param = $request->input();
        $param['type'] = self::platformType;

        $data = $accountManage->searchList($param);
        return view('launch.list', $data);
    }

    /**
     * 添加投放账号
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addAccount(Request $request)
    {
        $data = $request->all();

        if (empty($data['_token']))
            abort('非法请求！');

        $query = new AccountManage();
        $query->platform_nick = $data['pfname'] ?? null;
        $query->pid = $data['pt_type'] ?? null;
        $query->account = $data['username'] ?? null;
        $query->password = $data['passwd'] ?? null;
        $query->user_id = Auth::id();
        $query->save();

        return redirect('account/novel_configs');
    }
}
