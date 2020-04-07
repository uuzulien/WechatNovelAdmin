<?php


namespace App\Http\Controllers\SeekData\Api;


use App\Http\Controllers\Controller;
use App\Models\Task\TaskList;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getList(Request $request,TaskList $taskList)
    {
        $param = $request->all();
        $data = $taskList->getConfigList($param);
        return success($data);
    }
}
