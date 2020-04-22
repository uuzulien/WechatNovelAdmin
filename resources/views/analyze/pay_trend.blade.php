@extends('layouts.app')
    <style type="text/css">
        .creat_head_con {
            width: 100%;
            background: #fff;
            border-bottom: 1px solid #ccd5db;
        }
        .creat_head_con>ul {
            cursor: hand;
            margin: 0;
        }
        .creat_head_con>ul>li {
            display: inline-block;
            /* cursor: hand; */
            padding: 8px 8px 2px 8px;
            text-align: center;
        }
        .creat_head_con>ul>li div:nth-child(1) {
            padding-bottom: 8px;
        }
        .creat_head_con>ul>li:hover {
            background: rgb(21,147,255);
            color: #fff;
        }
        .content {
            width: 100%;
            height: 800px;
            background: pink;
            display: flex;
            justify-content: space-between;
        }
        .zoom-wrapper {
            width: 70%;
            /* height: 100%; */
            background: #eee;
            position: relative;
            display: inline-block;
        }
        .workspace_border {
            width: 326px;
            height: 640px;
            border-radius: 28px;
            background: rgba(224,224,224);
            position: absolute;
            top: 0;left: 0;right: 0;bottom: 0;
            margin: auto;
        }
        .workspace {
            width: 320px;
            height: 568px;
            background: #fff;
            position: absolute;
            top: 0;left: 0;right: 0;bottom: 0;
            margin: auto;
        }
        /* 页面工具栏 */
        .ws_tool {
            width: 5%;
            display: inline-block;
            box-sizing: border-box;
            text-align: center;
            background: #fff;
            border-left: 1px solid #ccd5db;
            border-right: 1px solid #ccd5db;
        }
        .ws_tool span {
            display: block;
            line-height: 40px;
            cursor: hand;
        }
        .ws_tool span:hover {
            color: #fff;
            background: rgb(21,147,255);
        }
        /* 页面工具框 */
        .containment {
            width: 25%;
            background: #fff;
            vertical-align: top;
            display: inline-block;
            box-sizing: border-box;
        }
        .nav_tabs {
            display: flex;
            justify-content: space-around;
        }
        .nav_tabs span {
            display: inline-block;
            width: 33.33%;
            text-align: center;
            line-height: 40px;
            background: #e0e0e0;
            color: #000000;
            cursor: hand;
        }
        .nav_tabs span:nth-child(3) {
            background: #fff;
        }
        .page_amend_loading {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }
        .page_amend_loading div:nth-child(1) {
            border: 1px solid #fff;
        }
        .page_amend_loading div {
            padding: 6px;
            border-radius: 3px;
            border: 1px solid #e6ebed;
            color: #333;
        }
    </style>


@section('pageTitle')
<div class="wrap">
    <div class="creat_head_con">
        <ul>
            <li>
                <div class="glyphicon glyphicon-th-list"></div>
                <div>标题</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-link"></div>
                <div>链接</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-picture"></div>
                <div>图片</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-folder-open"></div>
                <div>图集</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-facetime-video"></div>
                <div>轮播图</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-hand-up"></div>
                <div>按钮</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-play"></div>
                <div>视频</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-subscript"></div>
                <div>文本</div>
            </li>
            <li>
                <div class="glyphicon glyphicon-film"></div>
                <div>商品橱窗</div>
            </li>
        </ul>

    </div>
    <div class="content">
        <!-- 控制台 -->
        <div class="zoom-wrapper">
            <div class="workspace_border">
                <div class="workspace">

                </div>
            </div>
        </div>
        <!-- 页面工具栏 -->
        <div class="ws_tool">
            <span class="glyphicon glyphicon-arrow-left"></span>
            <span class="glyphicon glyphicon-share-alt"></span>
            <span class="glyphicon glyphicon-play"></span>
            <span class="glyphicon glyphicon-list-alt"></span>
            <span class="glyphicon glyphicon-music"></span>
            <span class="glyphicon glyphicon-fire"></span>
            <span class="glyphicon glyphicon-th"></span>
            <span class="glyphicon glyphicon-modal-window"></span>
            <span class="glyphicon glyphicon-plus big_pixel"></span>
            <span class="screen_percentage">100%</span>
            <span class="glyphicon glyphicon-minus minus_pixel"></span>
        </div>
        <!-- 页面工具箱 -->
        <div class="containment">
            <div class="nav_tabs">
                <span>页面属性</span>
                <span>图层管理</span>
                <span>页面管理</span>
            </div>
            <!-- 页面管理 -->
            <div class="page_amend">
                <div class="page_amend_loading">
                    <div >
                        <img src="../../public/img/h5/loading.png" alt="">
                        <span>加载页</span>
                    </div>
                    <div class="custom_loading">自定义加载页</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script type="text/javascript">
    var percentage_num = 100;
    var end_num = null;
    // 页面属性  图层管理  页面管理
    $('.nav_tabs span').each(function(index) {
        $(this).on('click', function() {
            $('.nav_tabs span').css('background','#e0e0e0');
            this.style.background = '#e0e0e0';
            this.style.background = '#ffffff';
        })
    });
    // 手机画布 缩小
    $('.minus_pixel').on('click', function() {
        if(percentage_num <= 100) {
            if(percentage_num > 50) {
                percentage_num -= 25;
            }
            end_num = '0.' + percentage_num - 0;
        }else if(percentage_num > 100) {
            percentage_num -= 25;
            end_num = percentage_num / 100;
        };
        phone_big_minus() // 调用 放大  缩小函数
    });
    // 手机画布  放大
    $('.big_pixel').on('click', function() {
        percentage_num < 125 ? percentage_num += 25 : percentage_num = 125
        if(percentage_num > 100) {
            end_num = percentage_num / 100;
        }else {
            end_num = '0.' + percentage_num - 0;
            if(end_num == 0.1) {
                end_num = 1
            }
        };
        phone_big_minus() // 调用 放大  缩小函数
    });
    // 手机画布  放大  缩小
    function phone_big_minus() {
        $('.screen_percentage').text( percentage_num + '%');
        $('.workspace_border').css({'width': 326 * end_num + 'px','height': 640 * end_num + 'px','border-radius': 28 * end_num + 'px'});
        $('.workspace').css({'width': 320 * end_num + 'px','height': 568 * end_num + 'px'})
    }























    // // 弹出框显示数据
    // let datas = @json($list);
    // // 弹出框点击事件
    // $('.data_analyze').click(function() {
    //     var day = $(this).data("day");
    //     $('.popup_wrap').css('display','block');
    //     particular();
    //     $(".popup_con").slideDown("slow");
    //     $('.remove').remove();
    //     // 合计
    //     $('.popup_table_con').append(
    //         `<tr  class="remove" id="total">
    //             <td>合计</td>
    //             <td>合计</td>
    //             <td>合计</td>
    //             <td>合计</td>
    //             <td>合计</td>
    //             <td>合计</td>
    //         </tr>`
    //     )
    //     var data = datas[day]['data'],
    //         total_money = 0;
    //     for(var i = 0; i < data.length; i++) {
    //         console.log(data[i]);
    //         total_money += data[i].today_moeny; // 累充
    //         data[i].back_moeny = datas[day].stat_cost ? ((total_money / datas[day].stat_cost) * 100).toFixed(2) : 0; // 回本
    //         if (i > 0){
    //             data[i].back_moeny_up_per = (data[i].back_moeny - data[i-1].back_moeny).toFixed(2);
    //         }else {
    //             data[i].back_moeny_up_per = '0.00';
    //         }
    //         $('.popup_table_con').append(`<tr class="remove">
    //                 <td>第 ${data[i].pay_time} 天</td>
    //                 <td>￥${datas[day].stat_cost}</td>
    //                 <td>￥${total_money}</td>
    //                 <td>￥${data[i].today_moeny}</td>
    //                 <td ${data[i].back_moeny > 100 ? "style='color: red;'" : ''}>${data[i].back_moeny}%</td>
    //                 <td ${data[i].back_moeny_up_per > 0 ? "style='color: red;'" : ''}>${data[i].back_moeny_up_per}%</td>
    //             </tr>`);
    //     }
    // });
</script>
@endsection
