@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>计划任务</li>
@endsection

@section('pageTitle')
    <div class="page-title">

        <div style="float:right">
            <a href="javascript:void(0);" class="btn btn-default" onclick="addday();">增加一天</a>
            <a href="javascript:void(0);" class="btn btn-default" onclick="delday();">减少一天</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="panel-body">
        <div role="tabpanel">
            <form action="{{route('spy.task.add')}}" method="post" class="form-horizontal">

                <!-- Tab panes -->
                <div class="tab-content" id="tab-content">
                    <div role="tabpanel" class="tab-pane active remove-1" id="tab_1">
                        <!-- Start Row -->
                        <div class="row">
                            <div class="col-md-12" id="addfrom_1">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">任务名称：</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="task_name" required>
                                            </div>

                                            <label for="input002" class="col-sm-2 control-label form-label">发文公众号：</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="squad">
                                                    <option value="0">请选择</option>
                                                    @foreach($pf_name as $item)
                                                        <option value="{{$item->id}}">{{$item->platform_nick}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group">

                                            <label for="input002" class="col-sm-2 control-label form-label">采集位置：</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="location">
                                                    <option value="0">请选择</option>
                                                    <option value="1">外推链接id</option>
                                                    <option value="2">被关注回复链接id</option>
                                                </select>
                                                <br>
                                                <input type="number" class="form-control" name="novel_id" required>
                                            </div>

                                            <label for="input002" class="col-sm-2 control-label form-label">任务类型：</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="pf_name">
                                                    <option value="0">请选择</option>
                                                @foreach($platforms as $item)
                                                        <option value="{{$item['id']}}">{{$item['platform_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <br>
                                                <select class="form-control" name="pfname">
                                                    <option value="0">请选择类型</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group">
{{--                                            <label for="input002" class="col-sm-2 control-label form-label">投放金额：</label>--}}
{{--                                            <div class="col-sm-2">--}}
{{--                                                <input type="number" class="form-control" name="stat_cost" required>--}}
{{--                                            </div>--}}
                                            <label for="input002" class="col-sm-2 control-label form-label">书籍名称：</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="novel_name" required>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
{{--                                        <div class="form-group">--}}
{{--                                            <label for="input002" class="col-sm-2 control-label form-label">执行周期：</label>--}}
{{--                                            <div class="col-sm-2">--}}
{{--                                                <select class="form-control" name="dispatch_location[0][]">--}}
{{--                                                    <option value="0">每天</option>--}}
{{--                                                    <option value="1">N天</option>--}}
{{--                                                    <option value="2">每小时</option>--}}
{{--                                                    <option value="2">N小时</option>--}}
{{--                                                    <option value="2">N分钟</option>--}}
{{--                                                    <option value="2">每星期</option>--}}
{{--                                                    <option value="2">每月</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">备注：</label>
                                            <div class="col-sm-10">
                                                <textarea class="class-textarea" name="description" rows="6" cols="46"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                        <div class="form-group" style="text-align:center;">
                            <button class="btn btn-primary pull-right">提交</button>

{{--                            <a href="javascript:void(0);" class="btn btn-info" onclick="">提交</a></div>--}}
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        let datas = @json($platforms->toArray());
        let pfname_control = $("select[name='pf_name']");
        let pfname_control_sub = document.querySelector("select[name='pfname']");

        pfname_control.change(function () {
            var pid = $("select[name='pf_name'] option:selected").val();
            pfname_control_sub.innerHTML = '';
            for(var i = 0; i < datas.length; i++) {
                if (pid == datas[i]['id']){
                    add_option(datas[i]['config'])
                }
            }
        });

        function add_option(item) {
            for(var key in item) {
                var query = document.createElement('option');
                query.innerHTML = item[key];
                query.value = key;
                pfname_control_sub.appendChild(query)
            }
        }


    </script>

@endsection
