<?php


namespace App\Http\Controllers\Novel;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Support\Facades\Auth;

class NovelAccountController extends Controller
{
    const platformType = 1;

    public function index(Request $request,AccountManage $accountManage)
    {
        $param = $request->input();
        $param['type'] = self::platformType;

        $data = $accountManage->searchList($param);
        return view('novel.list', $data);
    }

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
