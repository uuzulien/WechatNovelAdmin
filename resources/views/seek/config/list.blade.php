@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>配置清单列表详情</li>
@endsection

@section('pageTitle')

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
                                <th>配置名称</th>
                                <th>任务类型</th>
                                <th>登录配置</th>
                                <th>备注</th>
                                <th>操作人</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->platform_name}}</td>
                                    <td>{!! $item->config_data !!}</td>
                                    <td>{{$item->msg}}</td>
                                    <td>{{$item->user_name}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="javascript:void(0);">
                                        <span class="btn btn-sm btn-info">
                                        配置明细
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
