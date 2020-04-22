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
        @include('popup.analyze.trends')
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
                                <select  class="form-control" name="pdr" id="pdr" style="width:300px;">
                                    {{--                                    <option value="115" selected="">微距离001</option>--}}
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
                                    <span class="btn btn-default" data-toggle="modal" data-target="#trendModal" data-day="{{ $key }}">
                                        回本详情
                                    </span>
                                        <a href="{{route('analyst.pay_trend',['pdr'=> request()->get('pdr'), 'start_at' => explode('~',$key)[0], 'end_at' => explode('~',$key)[1]])}}" class="btn btn-warning">详情</a>

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
    <script>
        // 权限树
        var sel_datas = @json($groupTree);
        var sel_key = '{{request()->get('pdr')}}';
        var tree_content = `<option value="${sel_datas.key}" ${sel_key == sel_datas.key ? 'selected' : ''}>${sel_datas.name}</option>`;

        for (var i in sel_datas['datas']) {
            tree_content += `<option value="${sel_datas['datas'][i].key}" ${sel_key == sel_datas['datas'][i].key ? 'selected' : ''}>┖──${sel_datas['datas'][i].name}</option>`;
            for(var k = 0; k < sel_datas['datas'][i].datas.length; k++) {
                tree_content += `<option value="${sel_datas['datas'][i].datas[k].key}" ${sel_key == sel_datas['datas'][i].datas[k].key ? 'selected' : ''}>┊╌╌┖──${sel_datas['datas'][i].datas[k].name}</option>`;
            }
        }
        $('#pdr').html(tree_content);


        // 弹出框显示数据
        let datas = @json($list);

        // 回本详情
        $('#trendModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var day = button.data('day');
            var data = datas[day]['data'];
            var total_money = 0;
            var total_cost = 0;
            var content = '';
            var table = $('.modal-content tbody');

            var modal = $(this);
            modal.find('.modal-title').html('付费趋势 ' + '<b style="color: #00a0e9">' + day + '</b>');
            // if (datas[day].recharge_amounts > 0 ) {
            //     content = `<tr class="success">
            //         <td>合计</td>
            //         <td>￥${datas[day].stat_cost}</td>
            //         <td>￥${datas[day].recharge_amounts}</td>
            //         <td>合计</td>
            //         <td>${datas[day].recover_cost}</td>
            //         <td>合计</td>
            //     </tr>`;
            // }

            for(var i = 0; i < data.length; i++) {
                total_money += data[i].today_moeny; // 累充
                total_cost += data[i].stat_cost; // 累投
                data[i].back_moeny = total_cost ? ((total_money / total_cost) * 100).toFixed(2) : 0; // 回本
                if (i > 0){
                    data[i].back_moeny_up_per = (data[i].back_moeny - data[i-1].back_moeny).toFixed(2);
                }else {
                    data[i].back_moeny_up_per = '0.00';
                }
                content = `<tr>
                    <td>${data[i].pay_time}</td>
                    <td>￥${data[i].stat_cost ? (data[i].stat_cost).toFixed(2) : 0 }</td>
                    <td>￥${(total_cost).toFixed(2)}</td>
                    <td>￥${total_money}</td>
                    <td>￥${data[i].today_moeny}</td>
                    <td ${data[i].back_moeny > 100 ? "style='color: red;'" : ''}>${data[i].back_moeny}%</td>
                    <td ${data[i].back_moeny_up_per > 0 ? "style='color: red;'" : ''}>${data[i].back_moeny_up_per}%</td>
                </tr>` + content;
            }
            table.html(content);

        });

    </script>
@endsection
