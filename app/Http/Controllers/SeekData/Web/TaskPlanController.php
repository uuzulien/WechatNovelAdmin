<?php


namespace App\Http\Controllers\SeekData\Web;


use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\Task\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NovelAdv\AccountManage;
use App\Repositories\Auth\GroupPermission;


class TaskPlanController extends Controller
{
    // 计划首页视图
    public function index(GroupPermission $groupPermission)
    {
        $userGroup = $groupPermission->userGroup();
        $data = AccountManage::query()->whereIn('user_id', $userGroup)->get(['id','platform_nick']);

        return view('seek.task.index',['list' => $data]);

    }

    // 计划任务列表
    public function taskPlanList(TaskList $taskList)
    {
        $data = $taskList->searchList();
        return view('seek.task.list', $data);
    }

    // 计划任务添加
    public function taskPlanAdd(Request $request,RoleUser $roleUser)
    {
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
            DB::connection('admin')->table('task_list')->insert([
                'account_config_id' => $squad,
                'task_name' => $task_name,
                'pid' => $platform_id,
                'key' => $key,
                'user_id' => Auth::id(),
                'book_id' => $novel_id,
                'book_name' => $novel_name,
                'stat_cost' => $stat_cost,
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
