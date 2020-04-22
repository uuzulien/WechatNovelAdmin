@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>基础配置</li>
@endsection

@section('pageTitle')

@endsection

@section('content')
    <div class="panel-body">
        <div role="tabpanel">

                <!-- Tab panes -->
                <div class="tab-content" id="tab-content">
                    <div role="tabpanel" class="tab-pane active remove-1" id="tab_1">
                        <!-- Start Row -->
                        <div class="row">
                            <div class="col-md-12" id="addfrom_1">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">任务名称：</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="task_name"></div>
                                            <span style="margin-left: 20px;line-height: 2px"><i style="color: red;margin-right:8px;">*</i> 如：掌读-关注回复/外推链接/内推链接等等之类</span>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">执行类：</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="func"></div>
                                            <span style="margin-left: 20px;line-height: 2px"><i style="color: red;margin-right:8px;">*</i> 对接采集系统</span>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">任务类型：</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="pf_name">
                                                    @foreach($platforms as $item)
                                                    <option value="{{$item->id}}">{{$item->platform_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span style="margin-left: 20px;line-height: 2px"><i style="color: red;margin-right:8px;">*</i> 任务类型是指具体的小说平台、投放平台</span>
                                        </div>
                                        <br>
                                        <br>
                                        <!-- 登录配置--------------------------------------------------- -->
                                        <div class="form-group config_position">
                                            <label for="input002" class="col-sm-2 control-label form-label">登录配置：</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" id="form-control-one" name="squad[]">
                                                    <option value="0">请先添加</option>
                                                </select>

                                            </div>
                                            <!-- <div class="col-sm-2" id='add_sel_input'>
                                                <input type="text" class="form-control">

                                            </div> -->
                                            <!-- -----------------------------------默认--------------------------------------------------- -->
                                            <div class="login_config_form" id='config_hint'>
                                                <h5>基础配置</h5>
                                                <div class="text_0">
                                                    注意及时保存菜单配置，菜单只有发布后才会在手机侧显示
                                                    <br/>
                                                    微信对于公众号自定义菜单有一定缓存时间，发布菜单后如果想及时看到
                                                    <br/>
                                                    菜单修改，可以取消关注再重新关注公众号快速地看到新菜单。
                                                </div>
                                            </div>
                                            <!-- ------------------------------------------菜单内容---------------------------------------------------- -->
                                            <div class="login_config_form" id="config_text" style="display: none;">
                                                <h5 >基础配置</h5>
                                                <label for="">菜单名称（不超过5个汉字）</label>
                                                <input type="text" id="menuName">
                                                <label for="">菜单功能</label>
                                                <input type="text" id="urlAddress">
                                            </div>
                                            <div style="color: #656D78; font-weight: 1000; text-align: center; width: 20px; height: 20px; border: 1px solid #656D78; border-radius: 50%; line-height: 18px; display: inline-block; cursor:pointer; margin-top: 4px;" class="add_btn">+</div>
                                            <span style="margin-left: 20px;line-height: 2px"><i style="color: red;margin-right:8px;">*</i> 详细的参数配置</span>
                                        </div>
                                        <br>
                                        <br>
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label for="input002" class="col-sm-2 control-label form-label">执行周期：</label>--}}
                                        {{--                                            <div class="col-sm-2">--}}
                                        {{--                                                <select class="form-control" name="dispatch_location[0][]">--}}
                                        {{--                                                    <option value="0">每天</option>--}}
                                        {{--                                                    <option value="1">N天</option>--}}
                                        {{--                                                    <option value="2">每小时</option>--}}
                                        {{--                                                    <option value="2">N小时</option>--}}
                                        {{--                                                    <option value="2">N分钟</option>--}}
                                        {{--                                                    <option value="2">每星期</option>--}}
                                        {{--                                                    <option value="2">每月</option>--}}
                                        {{--                                                </select>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="input002" class="col-sm-2 control-label form-label">备注：</label>
                                            <div class="col-sm-10">
                                                <textarea class="class-textarea description" name="description" rows="6" cols="46"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                        <div class="form-group" style="text-align:center;">
                            <button class="btn btn-primary pull-right" onclick="sumbit()">提交</button>

                            {{--                            <a href="javascript:void(0);" class="btn btn-info" onclick="">提交</a></div>--}}
                        </div>
                    </div>

                </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        let login_control_one = document.getElementById('form-control-one');
        let login_control_sec = document.getElementById('form-control-two');
        let add_input = document.getElementById('add_input');
        let add_sel_input = document.getElementById('add_sel_input');
        // 菜单配置显隐
        let config_hint = document.getElementById('config_hint');
        let config_text = document.getElementById('config_text');
        // 菜单配置input
        let menuName = document.getElementById('menuName');
        let urlAddress = document.getElementById('urlAddress');
        // 添加菜单按钮
        let add_btn = document.querySelector('.add_btn');


        let show_sel = null;
        let sel_num = 0;
        var infor_datas = [
            {
                'HEADER':'{"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36"}',
                'LOGIN_URL':'https://novel.zhangdu520.com/default/login',
                'NEITUI_URL':'https://novel.zhangdu520.com/idispatch/list?type=1',
                'TARGET_URL':'http://admin.weijuli8.com/api/store/datas',
                'WAITUI_URL':'https://novel.zhangdu520.com/dispatch/list?type=1&key={}',
                'ACCOUNT_URL':'http://admin.weijuli8.com/api/book/get_account',
                'ORDER_API_URL':'https://novel.zhangdu520.com/order/api?action=getuserlist',
                'NEITUI_API_URL':'https://novel.zhangdu520.com/idispatch/api',
                'ORDER_PAGE_URL':'https://novel.zhangdu520.com/order/list',
                'TARGET_KEY_URL':'http://admin.weijuli8.com/api/book/get_keys?action=',
                'GUANZHU_API_URL':'https://novel.zhangdu520.com/dispatch/api',
                'HEAD_F_DATA':{"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8", "Connection": "close"},
                "FENS_PAGE_URL":"https://novel.zhangdu520.com/user/list",
                "GUANZHU_URL":'https://novel.zhangdu520.com/dispatch/follow-list?type=3&key={}'
            }
        ];

        let datas = [];

        // 添加数据信息
        add_btn.onclick = function() {
            datas.push(
                {
                    key:'属性名',
                    val:'url链接菜单'
                }
            );
            login_control_one.innerHTML = '';
            add_option();
            // 更新基础配置显隐
            config_hint.style.display = 'none';
            config_text.style.display = 'block';
            show_sel = datas[sel_num];
            menuName.value = show_sel.key;
            urlAddress.value = show_sel.val;
            var options = document.querySelectorAll('#form-control-one option');
            options[sel_num].selected = true;
        };
        // 添加option函数
        function add_option() {
            for(var i = 0; i < datas.length; i++) {
                var node = document.createElement('option');
                node.innerHTML = datas[i].key;
                login_control_one.appendChild(node)
            }
        }
        login_control_one.onchange = function() {
            // 更新基础配置显隐
            config_hint.style.display = 'none';
            config_text.style.display = 'block';
            sel_num = this.selectedIndex;
            show_sel = datas[sel_num];
            menuName.value = show_sel.key;
            urlAddress.value = show_sel.val;
        };
        menuName.onkeyup = function() {
            var options = document.querySelectorAll('#form-control-one option');
            datas[sel_num].key = menuName.value;
            options[sel_num].innerText = menuName.value
        };
        urlAddress.onkeyup = function() {
            var options = document.querySelectorAll('#form-control-one option');
            datas[sel_num].val = urlAddress.value;
        };

        function sumbit() {
            var task_name = $("input[name='task_name']").val(),
                pf_name = $("select[name='pf_name'] option:selected").val(),
                msg = document.querySelector('.description').value;

            if (task_name.length === 0) {
                alert('任务名称不能为空');
                return;
            }
            if (confirm('确定要提交本次配置吗？？')) {
                $.ajax({
                    type: 'post',
                    url: '{{route('spy.config.add')}}',
                    data: {task_name: task_name, pf_name: pf_name, msg : msg, datas: datas},
                    success: function (data) {
                        console.log(data);
                        if (data['code'] == 1) {
                            alert('提交成功');
                            // window.location.href = '';
                        } else {
                            alert('提交失败,请稍后重试或联系管理员!');
                        }
                    }
                }).fail(function (jqXHR, textStatus) {
                    alert(jqXHR);
                })
            }
        }
    </script>
@endsection
