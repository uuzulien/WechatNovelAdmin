@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>成本数据分析</li>
@endsection

@section('pageTitle')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="active">成本数据实时计算，充值数据根据采集数据完成后汇总一次</li>
        </ol>

    </div>
@endsection

@section('content')
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
{{--                        <ul class="nav nav-pills">--}}
{{--                            <li class=""><a href="/index.php/index/da/index.html">全部</a></li>--}}
{{--                            <li class=""><a href="/index.php/index/da/day.html">按天分析</a></li>--}}
{{--                            <li class=""><a href="/index.php/index/da/week.html">按周分析</a></li>--}}
{{--                            <li class="active"><a href="/index.php/index/da/month.html">按月分析</a></li>--}}
{{--                        </ul>--}}

                        <form class="form-inline">

{{--                            <div class="form-group">--}}
{{--                                <h5>派单日期</h5>--}}
{{--                                <div class="control-group">--}}
{{--                                    <div class="controls">--}}
{{--                                        <div class="input-prepend input-group">--}}
{{--                                            <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>--}}
{{--                                            <input id="addtime" name="addtime" class="form-control active" value="" placeholder="推送日期选择" type="text">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                            </div>--}}

                            <div class="form-group">
                                <h5>投放专员	</h5>
                                <select name="pdr" id="pdr" style="width:300px;">
                                    <option value="115" selected="">微距离001</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <h5>&nbsp;</h5>
                                <button type="submit" class="btn btn-default">搜索</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body table-responsive">

                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <td>投放日期</td>
                                <td>投放金额</td>
                                <td>充值金额</td>
                                <td>回本率</td>
                                <td>加粉数</td>
                                <td>粉单价</td>
                                <td>操作</td>
                            </tr>
                            </thead>
                            <tbody>
                            @if($list)
                            <tr class="success">
                                <td><b>合计</b>
                                </td>
                                <td>￥{{$total['cost_all']}}					</td>

                                <td>
                                    ￥{{$total['money_all']}}				</td>

                                <td>
                                    {{$total['recover_all']}}
                                </td>
                                <td>
                                    {{$total['all_follow_amount']}} 				</td>
                                <td>
                                    ￥{{$total['fens_all']}} 				</td>
                                <td>

                                </td>
                            </tr>
                            @endif
                            @foreach($list as $key => $item)
                            <tr>
                                <td><b>{{$key}}</b>
                                </td>
                                <td>￥{{$item['stat_cost']}}					</td>

                                <td>
                                    ￥{{$item['recharge_amounts']}}				</td>

                                <td>
                                    {{$item['recover_cost']}}				</td>
                                <td>
                                    {{$item['user_follow_amount']}}				</td>
                                <td>
                                    ￥{{$item['fens_cost']}}				</td>
                                <td>
                                    <a href="{{route('datas.novel_list',['start_at' => explode('~',$key)[0], 'end_at' => explode('~',$key)[1]])}}" class="btn btn-default">详情</a>
                                    <a href="javascript:void(0);" class="btn btn-warning">回本详情</a>

                                </td>
                            </tr>
                            @endforeach


                            </tbody>
                        </table>
                        <div style="text-align:right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
