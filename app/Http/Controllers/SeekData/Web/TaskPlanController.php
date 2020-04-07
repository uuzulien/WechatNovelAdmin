<?php


namespace App\Http\Controllers\SeekData\Web;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Task\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class TaskPlanController extends Controller
{
    // 计划首页视图
    public function index()
    {
        $role = Role::select('*')->paginate(10);

        return view('seek.task.index',['list' => $role]);
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
        $task_name = $request->input('task_name');
        $platform_id = $request->input('pfname');
        $squad = $request->input('squad');
        $description = $request->input('description');

        if ($squad == 0) {
            $list = DB::connection('admin')->table('account_config')->where('pid', $platform_id)->get();
        }
        else{
            $list = $roleUser->with(['role','hasManyAccountManage'])->where('role_id',$squad)->first()->hasManyAccountManage ?? null;
        }
        $inserList = [];
        foreach ($list as $item){
            array_push($inserList,[
                'ac_config_id' => $item->id,
                'task_name' => $task_name,
                'pid' => $platform_id,
                'description' => $description
            ]);
        }
        try {
            DB::connection('admin')->table('task_list')->insert($inserList);
        }catch (\Exception $e) {
            return redirect('spy/task/scheduler');
//            return abort('该任务已经存在了....');
        }



        return redirect('spy/task/scheduler');
    }
}
