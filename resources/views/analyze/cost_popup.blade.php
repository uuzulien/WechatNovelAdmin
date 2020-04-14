<style type="text/css">
    .popup_wrap {
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10;
        display: none;
    }
    .popup_con {
        width: 50%;
        height: 500px;
        background: #fff;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        font-size: 13px;
        display: none;
        z-index: 11;
    }
    .popup_title {
        padding: 10px 20px;
        background: rgb(248,248,248);
    }
    .popup_title span {
        margin: 0 8px;
    }
    .popup_table {
        height: 440px;
        overflow: auto;
    }
    .popup_table table{
        width: 95%;
        margin: 0 auto;
    }
    .popup_table th,.popup_table td{
        padding: 16px;
        border: 1px solid #f0f0f0;
        font-size: 13px;
    }
</style>

<div class="popup_wrap">

</div>
<div class="popup_con">
    <div class="popup_title">
        <span>数据分析</span>
{{--        <span>派单人：微距离；</span>--}}
{{--        <span>小说名：；</span>--}}
{{--        <span style="color: red;">(数据采集非实时：最多可能延迟2个小时)</span>--}}
    </div>
    <div class="popup_table">
        <table border="1" class="popup_table_con">
            <tr>
                <th>充值日期</th>
                <th>投放总金额</th>
                <th>充值总金额</th>
                <th>当日充值金额</th>
                <th>回本率</th>
                <th>回本率上升百分比</th>
            </tr>
            <!-- <tr>
                <td>${datas[i].pay_time}</td>
                <td>￥${datas[i].put_total_money}</td>
                <td>￥${datas[i].top_up_money}</td>
                <td>￥${datas[i].today_moeny}</td>
                <td>${datas[i].back_moeny}%</td>
                <td>${datas[i].back_moeny_up_per}%</td>
            </tr> -->
        </table>
    </div>
</div>

<script type="text/javascript">
    $('.popup_wrap').click(function(event) {
        $('.popup_con').css('display','none');
        $('.popup_wrap').css('display','none');
    })
</script>
