@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>计划列表</li>
@endsection

@section('pageTitle')
    {{--    <div class="page-title">--}}
    {{--        <h2>--}}
    {{--            <button--}}
    {{--                class="btn btn-sm btn-primary refuse" data-toggle="modal" data-target="#add_account">--}}
    {{--                <span class="glyphicon glyphicon-plus"></span> 新增账号--}}
    {{--            </button>--}}

    {{--        </h2>--}}
    {{--        @include('novel.add-account')--}}

    {{--    </div>--}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>任务名称</th>
                                <th>任务ID</th>
                                <th>任务类型</th>
                                <th>状态</th>
                                <th>周期</th>
                                <th>账号</th>
                                <th>执行时间</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $item)
                                <tr>
                                    <td>{{$item->task_name}}</td>
                                    <td>{{$item->task_id}}</td>
                                    <td>{{$item->platform_nick}}</td>
                                    <td> {!! $item->status !!}</td>
                                    <td>-</td>
                                    <td>{{$item->accout_name}}</td>
                                    <td>{{$item->run_time}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="">
                                        <span class="btn btn-sm btn-info">
                                        运行明细
                                        </span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                没有数据
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page">{{$list->appends($app->request->all())->links()}}</div>
            </div>

        </div>
    </div>
@endsection

@section('js')

@endsection
