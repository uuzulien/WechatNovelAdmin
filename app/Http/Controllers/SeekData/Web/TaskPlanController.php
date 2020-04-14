<?php


namespace App\Http\Controllers\SeekData\Web;


use App\Http\Controllers\Controller;
use App\Models\NovelAdv\PlatformManage;
use App\Models\RoleUser;
use App\Models\Task\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NovelAdv\AccountManage;
use App\Repositories\Auth\GroupPermission;
use function foo\func;


class TaskPlanController extends Controller
{
    // 计划首页视图
    public function index(GroupPermission $groupPermission)
    {
        $userGroup = $groupPermission->userGroup();
        $pf_name = AccountManage::query()->whereIn('user_id', $userGroup)->get(['id','platform_nick']);
        $platforms = PlatformManage::query()->with(['hasManyTaskConfigList'])->select(['id','platform_name'])->orderBy('id','ASC')->get()->map(function($value) {
            $item['id'] = $value->id;
            $item['platform_name'] = $value->platform_name;
            $tid = $value->hasManyTaskConfigList->pluck('id');
            $t_name = $value->hasManyTaskConfigList->pluck('name');
            $item['config'] = $tid->combine($t_name);
            return $item;
        });

        return view('seek.task.index', compact('pf_name', 'platforms'));

    }

    // 计划任务列表
    public function taskPlanList(TaskList $taskList)
    {
        $data = $taskList->searchList();
        return view('seek.task.list', $data);
    }

    // 计划任务添加
    public function taskPlanAdd(Request $request)
    {
        try {
            $task_name = $request->input('task_name');
            $platform_id = $request->input('pf_name');
            $squad = $request->input('squad');
            $description = $request->input('description');
            $novel_name = $request->input('novel_name');
            $novel_id = $request->input('novel_id');
            $task_config_id = $request->input('pfname');
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
            if ($task_config_id == 0 || $task_config_id == '未配置') {
                $validatorError = ['name' => '请选择任务类型，并在后台配置规则'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }
            DB::connection('admin')->table('task_list')->insert([
                'account_config_id' => $squad,
                'task_name' => $task_name,
                'pid' => $platform_id,
                'key' => $key,
                'user_id' => Auth::id(),
                'book_id' => $novel_id,
                'book_name' => $novel_name,
                'task_config_id' => $task_config_id,
                'description' => $description
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
