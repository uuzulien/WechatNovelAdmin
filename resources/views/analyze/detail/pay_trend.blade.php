@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>公众号付费趋势</li>
@endsection

@section('pageTitle')

@endsection

@section('content')
    @include('popup.data.add-const')
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
                                        <span class="label label-info">{{$item['platform_name']}}</span>
                                        @foreach($item['books_name'] as $book)
                                        <span class="label label-warning">{{$book}}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $item['recharge_amounts'] }}</td>
                                    <td>{{$item['stat_cost']}}</td>
                                    <td>{{ $item['recover_cost']}}</td>
                                    <td>
                                        <span class="btn btn-default" data-toggle="modal" data-target="#trendModal" data-day="{{ $key }}">
                                        回本详情
                                        </span>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$key}}">编辑</button>
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

        // 回本详情逻辑
        $('#trendModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var day = button.data('day');
            var data = datas[day]['data'];
            var total_money = 0;
            var content = '';
            var table = $('.modal-content tbody');
            var modal = $(this);

            modal.find('.modal-title').html('付费趋势 ' + '<b style="color: #00a0e9">@' + datas[day].platform_nick + '</b>');
            if (datas[day].recharge_amounts > 0 ) {
                content = `<tr class="success">
                    <td>合计</td>
                    <td>￥${datas[day].stat_cost}</td>
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
                    <td>￥${datas[day].stat_cost}</td>
                    <td>￥${total_money}</td>
                    <td>￥${data[i].today_moeny}</td>
                    <td ${data[i].back_moeny > 100 ? "style='color: red;'" : ''}>${data[i].back_moeny}%</td>
                    <td ${data[i].back_moeny_up_per > 0 ? "style='color: red;'" : ''}>${data[i].back_moeny_up_per}%</td>
                </tr>`;
            }
            table.html(content);

        });

        // 编辑逻辑
        var option = $("select[name='book_id']");
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('whatever');
            var data = datas[recipient];
            var option_content = '';
            option_data = [];

            var modal = $(this);
            modal.find('.modal-title').text('编辑');
            modal.find('.modal-body #platform-nick').val(data.platform_nick);
            modal.find('.modal-body #platform-name').val(data.platform_name);
            modal.find('.modal-body #cost-time').val('{{request()->get('time_at')}}');

            for (var key in data.books_name) {
                option_content += `<option value="${key}">${data.books_name[key]}</option>`;
                option_data.push(data.books_cost[key]);
            }
            option.html(option_content); // 添加下拉框
            modal.find('.modal-body #stat-cost').val(option_data[0]);

        });
        option.change(function(){
            sel_num = this.selectedIndex;
            $('#stat-cost').val(option_data[sel_num]);
        });
    </script>
@endsection
