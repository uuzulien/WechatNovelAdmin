<?php


namespace App\Http\Controllers\SeekData\Api;


use App\Http\Controllers\Controller;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * 获取账号配置相关数据
     * @param Request $request
     * @return mixed\
     */
    public function getConfigs(Request $request)
    {
        $user_id = $request->input('user_id');
        $query = new AccountManage();
        $data = $query->when($user_id, function ($q) use($user_id) {
            $q->where(['status' => 1 ,'user_id' => $user_id]);
        })->get(['id','platform_nick','account','password'])
            ->toArray();

        return success($data);
    }

    public function getKeyExist(Request $request)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'get_book_page':
                $data = DB::connection('admin')->table('grab_books_page')->pluck('book_id')->toArray();
                break;
            case 'get_order_page':
                $data = DB::connection('admin')->table('grab_orders_page')->pluck('order_num')->toArray();
                break;
            case 'get_order_api':
                $data = DB::connection('admin')->table('grab_orders_api')->pluck('book_user_id')->toArray();
                break;
            case 'get_book_api':
                $data = DB::connection('admin')->table('grab_books_api')->pluck('book_id')->toArray();
                break;
            case 'get_user_id':
                $data = DB::connection('admin')->table('grab_orders_page')->pluck('book_user_id')->toArray();
                break;
            default:
                $data =  [];
        }

        return success($data);

    }
}
