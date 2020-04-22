@extends('layouts.app')
<style type="text/css">
    .data_click {
        height: 60px;
        overflow: auto;
        /* text-overflow:ellipsis; */
        /* white-space: nowrap; */
        cursor: hand;
    }
    .pop_up {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: rgba(0,0,0,0.5);
        display: none;
    }
    .pop_up_pad {
        border: 1px solid #f0f0f0;
        width: 600px;
        height: 400px;
        overflow: auto;
        background: #ffffff;
        padding: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .pop_up_con {
        position: relative;
    }
    .pop_up_con_shut {
        width: 26px;
        height: 26px;
        text-align: center;
        line-height: 26px;
        border-radius: 50%;
        position: fixed;
        right: 10px;
        top: 10px;
        font-size: 16px;
        color: #ffffff;
        background: #33414e;
        cursor: hand;
        font-weight: 1000;
    }
</style>
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
                                    <td>
                                        <div class="data_click" title="点击查看更多" onclick="config({{ $item->config_data }})">
{{--                                            {!! $item->config_data !!}--}}
                                            点击查看登录配置

                                        </div>
                                    </td>
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
        <div class="pop_up">
            <div class="pop_up_pad">
                <div class="pop_up_con">
                    <!-- <img class="pop_up_con_shut" src="./s" alt=""> -->
                </div>
                <span class="pop_up_con_shut">×</span>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var datas =@json($list);
        console.log(datas.data)





        $('.pop_up_con_shut').click(function() {
            $('.pop_up').css('display','none');
        })

        function config(e) {
            // $.each(datas.data, function(i, val) {
            //     console.log(val)
            //     if(val.id == id) {
            //         console.log(val.datas)

            //         $('.pop_up').css('display','block');
            //         $('.pop_up_con').empty();
            //         for(data in val.datas) {
            //             console.log(data)
            //             var node = '<div style="color: #3AB54A;"><span style="color: #92278F;">"' + data + '"：</span>"' + val.datas[data] + '"</div>';
            //             $('.pop_up_con').append(node);
            //         }
            //     }
            // })
            popup_datas = e;
            $('.pop_up').css('display','block');
            $('.pop_up_con').empty();
            for(data in popup_datas) {
                var node = '<div style="color: #3AB54A;"><span style="color: #92278F;">"' + data + '"：</span>"' + popup_datas[data] + '"</div>';
                $('.pop_up_con').append(node);
            }
        }






        // var datas = {
        //     'LOGIN_URL':'https://novel.zhangdu520.com/default/login',
        //     'NEITUI_URL':'https://novel.zhangdu520.com/idispatch/list?type=1',
        //     'WAITUI_URL':'https://novel.zhangdu520.com/dispatch/list?type=1',
        //     'GUANZHU_URL':'https://novel.zhangdu520.com/dispatch/follow-list?type=3',
        //     'NEITUI_API_URL':'https://novel.zhangdu520.com/idispatch/api',
        //     'GUANZHU_API_URL':'https://novel.zhangdu520.com/dispatch/api',
        //     'ORDER_PAGE_URL':'https://novel.zhangdu520.com/order/list',
        //     'ORDER_API_URL':'https://novel.zhangdu520.com/order/api?action=getuserlist',
        //     'JL_CREATIVE_URL':'https://ad.oceanengine.com/promote/creative/stat_list/?_signature=zAOc1AAgEAIgP-fmaPT-LcwDnMAAJJ.',
        //     'HEAD_F_DATA':{"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8", "Connection": "close"},
        //     'HEADER':{"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36"},
        //     'USERNAME':'lgcm009',
        //     'PASSWD':'lgcmzd888...',
        //     'TARGET_URL':'http://admin.weijuli8.com/api/store/datas',
        //     'TARGET_KEY_URL':'http://admin.weijuli8.com/api/book/get_keys?action=',
        //     'ACCOUNT_URL':'http://admin.weijuli8.com/api/book/get_account'
        // };

        // let datas = $('.data_click').data('config') , test;
        // console.log(datas)

        // for(data in datas) {
        //     var node = "<div style='color: #3AB54A;'><span style='color: #92278F;'>" + data +"：</span>" + datas[data] + "</div>";
        //     $('.data_click').append(node);
        // }

        // $('.data_click').click(function() {

        // });


    </script>
@endsection
