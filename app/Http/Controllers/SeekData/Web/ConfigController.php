<?php


namespace App\Http\Controllers\SeekData\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Task\TaskConfigList;
use App\Models\Task\TaskList;
use App\Models\NovelAdv\PlatformManage;

class ConfigController extends Controller
{
    // 基础配置页面
    public function index()
    {
        $platforms = PlatformManage::query()->select(['id','platform_name'])->orderBy('id','ASC')->get();

        return view('seek.config.index', compact('platforms'));
    }

    // 配置清单页面
    public function showConfigList(TaskConfigList $taskConfigList)
    {
        $data = $taskConfigList->searchList();

        return view('seek.config.list', $data);
    }

    // 基础配置添加
    public function configAdd(Request $request)
    {
        $task_name = $request->input('task_name');
        $platform_name = $request->input('pf_name');
        $msg = $request->input('msg');
        $datas = $request->input('datas');
        $func = $request->input('func');

        if ($datas){
            $datas = $this->handData($datas);
        }
        DB::connection('admin')->table('task_config_list')->insert([
            'name' => $task_name,
            'pid' => $platform_name,
            'datas' => json_encode($datas),
            'msg' => $msg,
            'func' => $func,
            'user_id' => Auth::id()
        ]);

        return success();

    }

    // 格式化数组
    public function handData($data)
    {
        $dList = [];
        foreach ($data as $item) {
            $dList[$item['key']] = $item['val'];
        }
        return $dList;
    }
}
