<?php


namespace App\Http\Controllers\SeekData\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
{
    // 基础配置页面
    public function index()
    {
        return view('seek.config.index');
    }

    // 配置清单页面
    public function showConfigList()
    {
        return view('seek.config.list');
    }

    // 计划任务添加
    public function configAdd(Request $request)
    {
        return success($request->all());
        try {
            $task_name = $request->input('task_name');
            $platform_id = $request->input('pfname');
            $squad = $request->input('squad');
            $description = $request->input('description');
            $novel_name = $request->input('novel_name');
            $novel_id = $request->input('novel_id');
            $stat_cost = $request->input('stat_cost');
            $key = $request->input('location');

            if ($squad == 0) {
                $validatorError = ['name' => '请选择发文公众号'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }
            if ($key == 0) {
                $validatorError = ['name' => '请选择采集位置'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }
            DB::connection('admin')->table('task_config_list')->insert([
                'name' => $squad,
                'type' => $task_name,
                'datas' => $platform_id,
                'msg' => $key,
                'user_id' => Auth::id()
            ]);

            flash_message('操作成功');
            return redirect()->back();

        }catch (\Exception $e){
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect('spy/task/scheduler')
                ->withErrors($error)
                ->withInput();
        }

    }
}
