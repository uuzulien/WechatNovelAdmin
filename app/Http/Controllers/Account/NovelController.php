<?php


namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Support\Facades\Auth;

class NovelController extends Controller
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
}
