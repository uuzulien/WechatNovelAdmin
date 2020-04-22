@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>每月付费趋势</li>
@endsection

@section('pageTitle')

@endsection

@section('content')
    @include('popup.analyze.pay_trend')
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>新增日期</th>
                                <th>新增粉丝</th>
                                <th>新增累计充值</th>
                                <th>成本</th>
                                <th>回本率</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $item['user_follow_amount']}}</td>
                                    <td>{{ $item['recharge_amounts'] }}</td>
                                    <td>{{$item['stat_cost']}}</td>
                                    <td>{{ $item['recover_cost']}}</td>
                                    <td>

                                        <span class="btn btn-default" data-toggle="modal" data-target="#trendModal" data-day="{{ $key }}">
                                            付费趋势
                                        </span>
                                        <a href="{{route('analyst.detail.pay_trend',['pdr'=> request()->get('pdr'), 'time_at' => $key])}}" class="btn btn-warning">账号明细</a>

                                    </td>
                                </tr>
                            @empty
                                没有数据
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        // 弹出框显示数据
        let datas = @json($list);
        // 回本详情
        $('#trendModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var day = button.data('day');
            var data = datas[day]['data'];
            var total_money = 0;
            var content = '';
            var table = $('.modal-content tbody');
            var modal = $(this);

            modal.find('.modal-title').html('付费趋势 ' + '<b style="color: #00a0e9">@' + day + '</b>');
            if (datas[day].recharge_amounts > 0 ) {
                content = `<tr class="success">
                    <td>合计</td>
                    <td>￥${(datas[day].stat_cost).toFixed(2)}</td>
                    <td>￥${datas[day].recharge_amounts}</td>
                    <td>合计</td>
                    <td>${datas[day].recover_cost}</td>
                    <td>合计</td>
                </tr>`;
            }
            for(var i = 0; i < data.length; i++) {
                total_money += data[i].today_moeny; // 累充
                data[i].back_moeny = datas[day].stat_cost ? ((total_money / datas[day].stat_cost) * 100).toFixed(2) : 0; // 回本
                if (i > 0){
                    data[i].back_moeny_up_per = (data[i].back_moeny - data[i-1].back_moeny).toFixed(2);
                }else {
                    data[i].back_moeny_up_per = '0.00';
                }
                content += `<tr>
                    <td>第 ${data[i].pay_time} 天</td>
                    <td>￥${(datas[day].stat_cost).toFixed(2)}</td>
                    <td>￥${total_money}</td>
                    <td>￥${data[i].today_moeny}</td>
                    <td ${data[i].back_moeny > 100 ? "style='color: red;'" : ''}>${data[i].back_moeny}%</td>
                    <td ${data[i].back_moeny_up_per > 0 ? "style='color: red;'" : ''}>${data[i].back_moeny_up_per}%</td>
                </tr>`;
            }
            table.html(content);

        });
    </script>
@endsection
