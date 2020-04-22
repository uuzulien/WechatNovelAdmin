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
        width: 800px;
        height: 600px;
        background: #fff;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        font-size: 13px;
        display: none;
        z-index: 11;
        overflow: hidden;
    }
    .popup_title {
        padding: 10px 20px;
        background: rgb(248,248,248);
    }
    .popup_title span {
        margin: 0 8px;
    }
    .popup_table {
        height: 550px;
        overflow: auto;
        padding: 15px 0;
    }
    .popup_table table{
        width: 95%;
        margin: 0 auto;
    }
    .popup_table th,.popup_table td{
        padding: 16px 20px;
        border: 1px solid #f0f0f0;
        font-size: 13px;
    }
   .redact_div {
        padding: 10px 0 0;
        text-align: center;
    }
    .redact_sel {
        width: 50%;
        border-radius: 4px;
        padding: 5px;
        border: 1px solid #f0f0f0;
    }
    .redact_classname {
        width: 10%;
        text-align: right;
        color: #656C78;
        font-weight: 600;
        display: inline-block;
        margin-right: 10px;
    }
    .submit_wrap {
        margin-top: 30px;
        padding: 30px 160px 0 0;
        text-align: right;
    }
    .submit {
        background: #3FBAE4;
        color: #fff;
        padding: 5px 15px;
        border: 0;
        border-radius: 4px;
    }
/*    @media screen and (max-width: 1378px) {
        .popup_con {
            width: 800px;
        }
    } */
</style>

<div class="popup_wrap">

</div>
<div class="popup_con">

</div>

<script type="text/javascript">
    // 下拉信息
    var op_datas = [
        {key: 1, name: '至尊'},
        {key: 2, name: '深圳'},
        {key: 3, name: '罗湖'}
    ]
    $('.popup_wrap').click(function(event) {
        $('.popup_con').css('display','none');
        $('.popup_wrap').css('display','none');
    })
    // 添加详细信息头部结构函数
    function particular() {
        // 删除 popup_con 下所有子元素
        $('.popup_con').empty();
        $('.popup_con').append(`
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
                    </table>
                </div>
        `)
    };
    //  添加头部编辑结构弹出框
    function redact() {
        // 删除 popup_con 下所有子元素
        $('.popup_con').empty();
        $('.popup_con').append(`
            <div class="popup_title">
                <span>编辑</span>
            </div>
            <div class="redact_con">
                <div class="redact_div">
                    <span class="redact_classname">在投公众号</span>
                    <input type="text" class="redact_sel" value="111111" style="background: #eee; color: #ccc;" readonly>
                </div>
                <div class="redact_div">
                    <span class="redact_classname">平台</span>
                    <input type="text" class="redact_sel" value="111111" style="background: #eee; color: #ccc;" readonly>
                </div>
                <div class="redact_div">
                    <span class="redact_classname">小说名</span>
                    <select name="" id="" class="redact_sel add_sel_op">
                    </select>
                </div>
                <div class="redact_div">
                    <span class="redact_classname">推广成本</span>
                    <input type="text" class="redact_sel" required>
                </div>
            </div>
            <div class="submit_wrap">
                <button class="submit">提交</button>
            </div>
        `);
        $.each(op_datas, function(index, value) {
            $('.add_sel_op').append(`<option value="${value.key}">${value.name}</option>`)
        })
    }
</script>
