<?php


namespace App\Http\Controllers\SeekData\Api;


use App\Http\Controllers\Controller;
use http\Env\Response;
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
        $ancillary = $contents['attach'];
        $error = null;
        try{
            $this->save($action, $datas);
        }catch (\Exception $e) {
            $$error = $e;
    }


        $query = new AcceptHandleLog();
        $query->action = $action;
        $query->datas = json_encode($datas);
        $query->tid = $ancillary[0]['tid'] ?? null;
        $query->modules = $ancillary[0]['modules'] ?? null; // 采集的功能模块
        $query->compare_time = $ancillary[0]['compare_time'] ?? null;
        $query->politic = $ancillary[0]['politic'] ?? null;
        $query->breakpoint = $ancillary[0]['breakpoint'] ?? null;
        $query->save();

        if ($error)
            return response()->json(['message' => 'error', 'data' => $e]);
        return success();

    }

    public function save($action, $datas)
    {
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
                    'run_id' => $data['run_id'],
                    'run_time' => json_decode($data['run_time'])]);
                break;
            default:
                break;
        }
    }
}
