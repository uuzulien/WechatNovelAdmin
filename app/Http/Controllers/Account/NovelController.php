<?php


namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use App\Repositories\AdminHandleLog\AdminLogHandle;
use Illuminate\Http\Request;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NovelController extends Controller
{
    const platformType = 1;
    // 账户配置首页
    public function index(Request $request,AccountManage $accountManage)
    {
        $param = $request->input();
        $param['type'] = self::platformType;

        $data = $accountManage->searchList($param);
        return view('novel.list', $data);
    }

    // 添加一个账号
    public function addAccount(Request $request)
    {
        try {
            $data = $request->all();

            if (empty($data['_token']))
                abort('非法请求！');

            if ($data['pt_type'] == "0") {
                $validatorError = ['name' => '请选择平台来源'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }

            $query = new AccountManage();
            $query->platform_nick = $data['pfname'] ?? null;
            $query->pid = $data['pt_type'] ?? null;
            $query->account = $data['username'] ?? null;
            $query->password = $data['passwd'] ?? null;
            $query->user_id = Auth::id();
            $query->save();

            return redirect('account/novel_configs');
        }catch (\Exception $e){
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect('account/novel_configs')
                ->withErrors($error)
                ->withInput();
        }

    }
    // 修改账号
    public function amdAccount(Request $request)
    {
        try {
            $data = $request->all();
            $id = $data['id'];

            if (empty($data['_token']))
                abort('非法请求！');

            if ($data['pt_type'] == "0") {
                $validatorError = ['name' => '请选择平台来源'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }

            $query = AccountManage::find($id);
            $query->platform_nick = $data['pfname'] ?? null;
            $query->pid = $data['pt_type'] ?? null;
            $query->account = $data['username'] ?? null;
            $query->password = $data['passwd'] ?? null;
            $query->save();

            flash_message('操作成功');
            return redirect()->back();
        }catch (\Exception $e){
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect('account/novel_configs')
                ->withErrors($error)
                ->withInput();
        }
    }

    // 广点通页面删除
    public function deleteAccount($id)
    {
        $account = AccountManage::find($id);
        $account->delete();
        AdminLogHandle::write();

        return success('删除成功');
    }
}
