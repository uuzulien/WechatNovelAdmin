@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>投放数据汇总</li>
        @endsection

        @section('pageTitle')
{{--            <div class="page-title">--}}
{{--                <h2>--}}
{{--                    <button--}}
{{--                        class="btn btn-sm btn-primary refuse" data-toggle="modal" data-target="#add_account">--}}
{{--                        <span class="glyphicon glyphicon-plus"></span> 新增账号--}}
{{--                    </button>--}}

{{--                </h2>--}}
{{--                @include('novel.add-account')--}}

{{--            </div>--}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                {{--                <div class="panel-heading">--}}
                {{--                    <form class="form-inline">--}}
                {{--                        <div class="form-group">--}}
                {{--                            --}}{{--                            <label>--}}
                {{--                            --}}{{--                                <select id="keyword" class="compensatory-style pay_status_style" autocomplete="off" name="key">--}}
                {{--                            --}}{{--                                    <option value="pfname" @if(request()->get('key')=='pfname') selected @endif>平台名称</option>--}}
                {{--                            --}}{{--                                    <option value="account" @if(request()->get('key')=='account') selected @endif>账号</option>--}}
                {{--                            --}}{{--                                </select>--}}
                {{--                            --}}{{--                                <input type="text" class="user-name-style" autocomplete="off" name="word" value="{{request()->get('word')}}">--}}
                {{--                            --}}{{--                            </label>--}}
                {{--                            <label>平台:--}}
                {{--                                <select id="select-id" class="compensatory-style pay_status_style" autocomplete="off" name="pt_type">--}}
                {{--                                    <option value="0" >所有平台</option>--}}
                {{--                                    <option value="1" >掌读</option>--}}
                {{--                                </select>--}}
                {{--                            </label>--}}
                {{--                            <label>账户状态:--}}
                {{--                                <select id="select-id" class="compensatory-style pay_status_style" autocomplete="off" name="status">--}}
                {{--                                    <option value="0" >所有状态</option>--}}
                {{--                                    <option value="1" @if(request()->get('status')=='1') selected @endif>正常</option>--}}
                {{--                                    <option value="2" @if(request()->get('status')=='2') selected @endif>异常</option>--}}
                {{--                                </select>--}}
                {{--                            </label>--}}
                {{--                        </div>--}}

                {{--                        <button type="submit" class="btn btn-default">搜索</button>--}}
                {{--                    </form>--}}
                {{--                </div>--}}
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>书的id</th>
                                <th>广告创意</th>
                                <th>消耗</th>
                                <th>展示数</th>
                                <th>点击数</th>
                                <th>转化数</th>
                                <th>投放时间</th>
                                <th>计划名称</th>
                                <th>广告组名称</th>
                                <th>落地页链接</th>
                                <th>更新时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                            @forelse($list as $item)--}}
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            {{--                            @empty--}}
                            没有数据
                            {{--                            @endforelse--}}
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--                <div class="page">{{$list->appends($app->request->all())->links()}}</div>--}}
            </div>

        </div>
    </div>

@endsection

@section('js')

@endsection
