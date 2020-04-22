@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>小说数据汇总</li>
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
                <div class="panel-heading">
                    <form class="form-inline">
                        <div class="form-group">
                            <label>平台:
                                <select id="select-id" class="compensatory-style pay_status_style" autocomplete="off" name="pt_type">
                                    <option value="0" >所有平台</option>
                                    @foreach($platforms as $item)
                                        <option value="{{$item->id}}" @if(request()->get('pt_type')==$item->id) selected @endif>{{$item->platform_name}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>新建时间</th>
                                <th>投放专员</th>
                                <th>派单详情</th>
                                <th>在投公众号</th>
                                <th>阅读详情</th>
                                <th>小说id</th>
                                <th>小说名</th>
                                <th>平台</th>
                                <th>数据更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $item)
                                <tr>
                                    <td>{{$item->book_create_time}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{!! $item->launch_detail !!}</td>
                                    <td>{{$item->platform_nick}}</td>
                                    <td>{!! $item->read_detail !!}</td>
                                    <td>{{$item->book_id}}</td>
                                    <td>{{$item->book_name}}</td>
                                    <td>{{$item->platform_name}}</td>
                                    <td>{{$item->updated_at}}</td>
                                    <td>
                                        @if($item->has_order)
                                        <a href="{{route('datas.order_list',['book_id' => $item->book_id])}}">
                                        <span class="btn btn-sm btn-info">
                                        订单明细
                                        </span>
                                            </a>
                                        @else
                                        <a href="javascript:void(0)">
                                        <span class="btn btn-sm btn-info" data-toggle="tooltip" title="" data-original-title="没有充值记录" data-placement="left" >
                                        订单明细
                                        </span>
                                        </a>
                                        @endif
{{--                                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_const_{{$item->id}}">--}}
{{--                                        编辑--}}
{{--                                        </span>--}}

{{--                                        @include('datas.novel.add-const')--}}
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
