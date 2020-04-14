@extends('layouts.app')
    <style type="text/css">
        .remove:nth-child(2n + 1) {
            background: rgba(240,244,249,0.7);
        }
        .wrap_label {
            padding: 8px;
            display: inline-block;
            cursor: hand;
        }
    </style>
@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>公众号付费趋势</li>
@endsection

@section('pageTitle')

@endsection

@section('content')
    @include('analyze.cost_popup')
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
                                <th>标签</th>
                                <th>新增累计充值</th>
                                <th>成本</th>
                                <th>回本率</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $key => $item)
                                <tr>
                                    <td>{{ $item['platform_nick'] }}</td>
                                    <td>{{ $item['user_follow_amount']}}</td>
                                    <td class="col-sm-2">
                                        @foreach($item['books_name'] as $book)
                                        <div class="wrap_label">
                                            <span class="label label-warning" id="label">{{$book}}</span>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td>{{ $item['recharge_amounts'] }}</td>
                                    <td>{{$item['stat_cost']}}</td>
                                    <td>{{ $item['recover_cost']}}</td>
                                    <td>
                                        <span class="btn btn-default data_analyze" data-day="{{ $key }}">
                                        每日明细
                                        </span>
                                        <span class="btn btn-default data_analyze">
                                        编辑
                                        </span>
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
<script type="text/javascript">
    // 弹出框显示数据
    let datas = @json($list);

    // 弹出框点击事件
    $('.data_analyze').click(function() {
        var day = $(this).data("day");
        console.log(day)
        $('.popup_wrap').css('display','block');
        $('.remove').remove();
        if(day) {
            $(".popup_con").slideDown("slow");
            particular();
            var data = datas[day]['data'],
                total_money = 0;
            // 合计
            $('.popup_table_con').append(
                `<tr  class="remove">
                    <td>合计</td>
                    <td>合计</td>
                    <td>合计</td>
                    <td>合计</td>
                    <td>合计</td>
                    <td>合计</td>
                </tr>`
            )
            console.log(data)
            for(var i = 0; i < data.length; i++) {
                console.log(data[i]);
                total_money += data[i].today_moeny; // 累充
                data[i].back_moeny = datas[day].stat_cost ? ((total_money / datas[day].stat_cost) * 100).toFixed(2) : 0; // 回本
                if (i > 0){
                    data[i].back_moeny_up_per = (data[i].back_moeny - data[i-1].back_moeny).toFixed(2);
                }else {
                    data[i].back_moeny_up_per = '0.00';
                }
                $('.popup_table_con').append(`<tr class="remove">
                        <td>第 ${data[i].pay_time} 天</td>
                        <td>￥${datas[day].stat_cost}</td>
                        <td>￥${total_money}</td>
                        <td>￥${data[i].today_moeny}</td>
                        <td>${data[i].back_moeny}%</td>
                        <td>${data[i].back_moeny_up_per}%</td>
                    </tr>`);
            }
        }else {
            $(".popup_con").slideDown("slow");
            redact()
        }
    });
</script>
@endsection
