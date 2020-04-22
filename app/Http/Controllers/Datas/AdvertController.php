<?php


namespace App\Http\Controllers\Datas;


use App\Http\Controllers\Controller;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertController extends Controller
{
    public function index()
    {
        $list = ['list' => []];
        return view('datas.advert.list',$list);
    }

    public function addMoney(Request $request)
    {
        try {
            $data = $request->all();

            if (empty($data['_token']))
                abort('非法请求！');

            if ($data['stat_cost'] == "") {
                $validatorError = ['name' => '请输入本次消耗金额'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }

            $book_id = $data['book_id'];
            $stat_cost = $data['stat_cost'];
            $cost_time = $data['cost_time'];

            DB::connection('admin')->table('grab_launch')->updateOrInsert(array('book_id' => $book_id, 'cost_time' => $cost_time), array('stat_cost' => $stat_cost));

            flash_message('操作成功');
            return redirect()->back();

        }catch (\Exception $e){
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect('data_analyst/detail/pay_trend?time_at='.$request->input('cost_time'))
                ->withErrors($error)
                ->withInput();

        }
    }
}
