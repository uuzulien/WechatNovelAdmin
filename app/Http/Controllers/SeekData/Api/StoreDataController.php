<?php


namespace App\Http\Controllers\SeekData\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AcceptHandleLog;
use Illuminate\Support\Carbon;

class StoreDataController extends Controller
{
    /**
     * 数据存储中心，负责存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function center(Request $request)
    {
        $contents = json_decode($request->getContent(),true);

        $datas = $contents['datas'];
        $action = $contents['action'];

        try {
            switch ($action) {
                case 'get_book_page':
                    DB::connection('admin')->table('grab_books_page')->insert($datas);
                    break;
                case 'get_order_page':
                    DB::connection('admin')->table('grab_orders_page')->insert($datas);
                    break;
                case 'get_order_api':
                    DB::connection('admin')->table('grab_orders_api')->insert($datas);
                    break;
                case 'get_book_api':
                    DB::connection('admin')->table('grab_books_api')->insert($datas);
                    break;
                case 'task_list':
                    $data = $datas[0];
                    DB::connection('admin')->table('task_list')->where('id',$data['id'])->update(['status' => $data['status'],
                        'task_id' => $data['task_id'],
                        'run_time' => json_decode($data['run_time'])]);
                    break;
                default:
                    return error();
            }

            AcceptHandleLog::create([
                'action' => $action,
                'datas' => $datas,
                'message' => $request->input('message',null)
            ]);

        } catch (\Exception $e) {
            return success($e);
    }


        return success();
    }

}
